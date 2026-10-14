<?php

namespace Tests\Feature;

use App\Http\Middleware\ActiveSubscription;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Requiere una BD con el esquema real (las migraciones no lo reflejan completo):
 * DB_DATABASE=the_black_hand_test php artisan test --filter=WhopWebhookTest
 */
class WhopWebhookTest extends TestCase
{
    use DatabaseTransactions;

    private const SECRET  = 'ws_test_secret';
    private const COMPANY = 'biz_test_company';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        if (DB::getDatabaseName() === 'the_black_hand') {
            $this->markTestSkipped('No se ejecuta contra la BD de desarrollo');
        }

        Mail::fake();

        config([
            'services.whop.webhook_secret' => self::SECRET,
            'whop.whop_company_id'         => self::COMPANY,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('plans')->insert([
            ['id' => Plan::ID_PLAN_ELITE, 'name' => 'ELITE', 'source' => 'elite', 'price' => 30, 'duration_days' => 0, 'is_active' => 1],
            ['id' => 2, 'name' => 'SUSCRIPCION', 'source' => 'suscripcion', 'price' => 50, 'duration_days' => 30, 'is_active' => 1],
        ]);

        $userId = DB::table('users')->insertGetId([
            'email' => 'whop-test@example.com', 'password' => 'x', 'rol_id' => 1, 'is_active' => 1,
        ]);
        DB::table('users_profiles')->insert([
            'user_id' => $userId, 'first_name' => 'test', 'last_name' => 'user', 'completed_profile' => 1,
        ]);

        $this->user = User::find($userId);
    }

    public function test_rechaza_firma_invalida(): void
    {
        $body = json_encode($this->paymentEvent('evt_1', 'pay_1', 'suscripcion'));

        $this->postWebhook($body, ['webhook-signature' => 'v1,firmamala'])->assertStatus(401);
        $this->assertDatabaseMissing('whop_webhook_events', ['event_id' => 'evt_1']);
    }

    public function test_rechaza_timestamp_antiguo(): void
    {
        $body = json_encode($this->paymentEvent('evt_1', 'pay_1', 'suscripcion'));

        $this->postWebhook($body, [], time() - 3600)->assertStatus(401);
    }

    public function test_acepta_header_con_varias_firmas(): void
    {
        $body = json_encode($this->paymentEvent('evt_1', 'pay_1', 'suscripcion'));
        $ts   = time();

        $this->postWebhook($body, [
            'webhook-signature' => 'v1,otrafirma ' . $this->sign('msg_evt_1', $ts, $body),
        ], $ts)->assertOk();
    }

    public function test_pago_exitoso_activa_suscripcion(): void
    {
        $this->sendEvent($this->paymentEvent('evt_1', 'pay_1', 'suscripcion'))->assertOk()->assertSee('OK');

        $subscription = Subscription::where('user_id', $this->user->id)->first();

        $this->assertNotNull($subscription);
        $this->assertSame(Subscription::STATUS_ACTIVE, $subscription->subscription_status);
        $this->assertSame('mem_1', $subscription->whop_membership_id);
        $this->assertTrue($subscription->subscription_expires_at->equalTo(now()->addDays(30)->startOfDay()));

        $this->assertDatabaseHas('payments', ['payment_id' => 'pay_1', 'website_user_id' => $this->user->id]);
        $this->assertDatabaseHas('whop_webhook_events', ['event_id' => 'evt_1', 'user_id' => $this->user->id]);
        $this->assertDatabaseHas('notifications', ['user_id' => $this->user->id]);

        $this->assertTrue(app(ActiveSubscriptionProbe::class)->allows($this->user));
    }

    public function test_evento_duplicado_no_se_procesa_dos_veces(): void
    {
        $event = $this->paymentEvent('evt_1', 'pay_1', 'suscripcion');

        $this->sendEvent($event)->assertOk();
        $expires = Subscription::where('user_id', $this->user->id)->value('subscription_expires_at');

        $this->sendEvent($event)->assertOk()->assertSee('Already processed');

        $this->assertSame(1, Subscription::where('user_id', $this->user->id)->count());
        $this->assertEquals($expires, Subscription::where('user_id', $this->user->id)->value('subscription_expires_at'));
        $this->assertSame(1, DB::table('notifications')->where('user_id', $this->user->id)->count());
    }

    public function test_renovacion_con_plan_vigente_suma_dias_y_reutiliza_registro(): void
    {
        $this->sendEvent($this->paymentEvent('evt_1', 'pay_1', 'suscripcion', 50, 'mem_1'))->assertOk();
        $this->sendEvent($this->paymentEvent('evt_2', 'pay_2', 'suscripcion', 50, 'mem_2'))->assertOk();

        $subscriptions = Subscription::where('user_id', $this->user->id)->get();

        $this->assertCount(1, $subscriptions);
        $this->assertSame('mem_2', $subscriptions->first()->whop_membership_id);
        $this->assertTrue($subscriptions->first()->subscription_expires_at->equalTo(now()->addDays(60)->startOfDay()));
    }

    public function test_renovacion_de_plan_vencido_cuenta_desde_hoy(): void
    {
        Subscription::create([
            'user_id'                 => $this->user->id,
            'subscription_status'     => Subscription::STATUS_EXPIRED,
            'subscription_plan'       => 'suscripcion',
            'subscription_expires_at' => now()->subDays(10),
        ]);

        $this->sendEvent($this->paymentEvent('evt_1', 'pay_1', 'suscripcion'))->assertOk();

        $subscription = Subscription::where('user_id', $this->user->id)->sole();
        $this->assertSame(Subscription::STATUS_ACTIVE, $subscription->subscription_status);
        $this->assertTrue($subscription->subscription_expires_at->equalTo(now()->addDays(30)->startOfDay()));
    }

    public function test_monto_menor_al_plan_no_activa(): void
    {
        $this->sendEvent($this->paymentEvent('evt_1', 'pay_1', 'suscripcion', 1))->assertOk();

        $this->assertSame(0, Subscription::where('user_id', $this->user->id)->count());
        $this->assertDatabaseHas('whop_webhook_events', ['event_id' => 'evt_1']);
    }

    public function test_otra_empresa_no_activa(): void
    {
        $event                          = $this->paymentEvent('evt_1', 'pay_1', 'suscripcion');
        $event['data']['company']['id'] = 'biz_otra';

        $this->sendEvent($event)->assertOk();

        $this->assertSame(0, Subscription::where('user_id', $this->user->id)->count());
    }

    public function test_pago_no_exitoso_no_activa(): void
    {
        $event                      = $this->paymentEvent('evt_1', 'pay_1', 'suscripcion');
        $event['data']['substatus'] = 'failed';

        $this->sendEvent($event)->assertOk();

        $this->assertSame(0, Subscription::where('user_id', $this->user->id)->count());
        $this->assertDatabaseHas('payments', ['payment_id' => 'pay_1', 'substatus' => 'failed']);
    }

    public function test_elite_con_pick_publicado_hoy_empieza_manana(): void
    {
        DB::table('picks')->insert(['plan_id' => Plan::ID_PLAN_ELITE, 'created_at' => now(), 'updated_at' => now()]);

        $this->sendEvent($this->paymentEvent('evt_1', 'pay_1', 'elite', 30))->assertOk();

        $subscription = Subscription::where('user_id', $this->user->id)->sole();
        $this->assertTrue($subscription->subscription_expires_at->equalTo(now()->addDay()->startOfDay()));
    }

    public function test_pick_elite_no_agrega_dia_a_otros_planes(): void
    {
        DB::table('picks')->insert(['plan_id' => Plan::ID_PLAN_ELITE, 'created_at' => now(), 'updated_at' => now()]);

        $this->sendEvent($this->paymentEvent('evt_1', 'pay_1', 'suscripcion'))->assertOk();

        $subscription = Subscription::where('user_id', $this->user->id)->sole();
        $this->assertTrue($subscription->subscription_expires_at->equalTo(now()->addDays(30)->startOfDay()));
    }

    public function test_membership_deactivated_expira_suscripcion(): void
    {
        $this->sendEvent($this->paymentEvent('evt_1', 'pay_1', 'suscripcion'))->assertOk();

        $this->sendEvent([
            'id'   => 'evt_2',
            'type' => 'membership.deactivated',
            'data' => ['id' => 'mem_1', 'status' => 'expired'],
        ])->assertOk();

        $this->assertSame(Subscription::STATUS_EXPIRED, Subscription::where('user_id', $this->user->id)->value('subscription_status'));
        $this->assertDatabaseHas('whop_webhook_events', ['event_id' => 'evt_2', 'user_id' => $this->user->id]);
        $this->assertFalse(app(ActiveSubscriptionProbe::class)->allows($this->user));
    }

    public function test_middleware_bloquea_suscripcion_vencida_aunque_siga_active(): void
    {
        Subscription::create([
            'user_id'                 => $this->user->id,
            'subscription_status'     => Subscription::STATUS_ACTIVE,
            'subscription_plan'       => 'suscripcion',
            'subscription_expires_at' => now()->subDays(2),
        ]);

        $this->assertFalse(app(ActiveSubscriptionProbe::class)->allows($this->user));
    }

    private function paymentEvent(string $eventId, string $paymentId, string $plan, float $total = 50, string $membershipId = 'mem_1'): array
    {
        return [
            'id'   => $eventId,
            'type' => 'payment.succeeded',
            'data' => [
                'id'         => $paymentId,
                'status'     => 'paid',
                'substatus'  => 'succeeded',
                'total'      => $total,
                'currency'   => 'usd',
                'paid_at'    => now()->toIso8601String(),
                'user'       => ['id' => 'user_1', 'username' => 'tester'],
                'plan'       => ['id' => 'plan_1'],
                'company'    => ['id' => self::COMPANY],
                'membership' => ['id' => $membershipId],
                'metadata'   => ['website_user_id' => $this->user->id, 'website_plan' => $plan],
            ],
        ];
    }

    private function sendEvent(array $event)
    {
        return $this->postWebhook(json_encode($event), [], null, 'msg_' . $event['id']);
    }

    private function postWebhook(string $body, array $headers = [], ?int $timestamp = null, string $webhookId = 'msg_evt_1')
    {
        $timestamp ??= time();

        $headers = array_merge([
            'webhook-id'        => $webhookId,
            'webhook-timestamp' => (string)$timestamp,
            'webhook-signature' => $this->sign($webhookId, $timestamp, $body),
        ], $headers);

        $server = ['CONTENT_TYPE' => 'application/json'];
        foreach ($headers as $name => $value) {
            $server['HTTP_' . strtoupper(str_replace('-', '_', $name))] = $value;
        }

        return $this->call('POST', '/api/whop/webhook', [], [], [], $server, $body);
    }

    private function sign(string $webhookId, int $timestamp, string $body): string
    {
        return 'v1,' . base64_encode(hash_hmac('sha256', "{$webhookId}.{$timestamp}.{$body}", self::SECRET, true));
    }
}

/**
 * Ejecuta el middleware ActiveSubscription como lo haría la ruta /picks.
 */
class ActiveSubscriptionProbe
{
    public function allows(User $user): bool
    {
        auth()->setUser($user);

        $request = Request::create('/picks');
        $request->setUserResolver(fn() => $user);

        $response = app(ActiveSubscription::class)->handle($request, fn() => response('picks'));

        return $response->getContent() === 'picks';
    }
}
