<?php

namespace App\Services\User;

use App\Models\PushSubscription;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class WebPushServices
{
    public function enabled(): bool
    {
        return filled(config('webpush.vapid.public_key')) && filled(config('webpush.vapid.private_key'));
    }

    public function subscribe(int $userId, array $data, ?string $userAgent = null): PushSubscription
    {
        return PushSubscription::updateOrCreate(
            ['endpoint_hash' => hash('sha256', $data['endpoint'])],
            [
                'user_id'    => $userId,
                'endpoint'   => $data['endpoint'],
                'p256dh'     => $data['keys']['p256dh'],
                'auth'       => $data['keys']['auth'],
                'user_agent' => $userAgent ? substr($userAgent, 0, 250) : null,
            ]
        );
    }

    public function unsubscribe(int $userId, string $endpoint): void
    {
        PushSubscription::where('user_id', $userId)
            ->where('endpoint_hash', hash('sha256', $endpoint))
            ->delete();
    }

    /**
     * Envía la notificación a todos los dispositivos de los usuarios.
     * Las suscripciones caducadas (404/410) se eliminan solas.
     */
    public function sendToUsers(array $userIds, array $payload): int
    {
        if (!$this->enabled() || empty($userIds)) {
            return 0;
        }

        $subscriptions = PushSubscription::whereIn('user_id', $userIds)->get();
        if ($subscriptions->isEmpty()) {
            return 0;
        }

        $webPush = new WebPush(['VAPID' => [
            'subject'    => config('webpush.vapid.subject'),
            'publicKey'  => config('webpush.vapid.public_key'),
            'privateKey' => config('webpush.vapid.private_key'),
        ]]);

        foreach ($subscriptions as $sub) {
            $webPush->queueNotification(
                Subscription::create([
                    'endpoint' => $sub->endpoint,
                    'keys'     => ['p256dh' => $sub->p256dh, 'auth' => $sub->auth],
                ]),
                json_encode($payload),
                ['TTL' => 3600, 'urgency' => 'high']
            );
        }

        $sent = 0;
        foreach ($webPush->flush() as $report) {
            if ($report->isSuccess()) {
                $sent++;
                continue;
            }
            if ($report->isSubscriptionExpired()) {
                PushSubscription::where('endpoint_hash', hash('sha256', $report->getEndpoint()))->delete();
            } else {
                Log::warning('Web push fallido', ['reason' => $report->getReason()]);
            }
        }

        return $sent;
    }
}
