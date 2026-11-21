<?php

namespace App\Jobs;

use App\Models\Country;
use App\Models\User;
use App\Services\User\WebPushServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/** Avisa por push (navegador) a los clientes a los que se les envió un pick, en su idioma. */
class SendPickPushJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries   = 1;

    public function __construct(protected array $userIds, protected string $planName = '')
    {
        $this->onQueue('emails-picks');
    }

    public function handle(WebPushServices $push): void
    {
        $default = config('app.locale');
        $valid   = [Country::LANGUAGE_ES, Country::LANGUAGE_EN];

        // Un envío por idioma: cada cliente recibe el aviso en el suyo
        $byLocale = User::whereIn('id', $this->userIds)->get(['id', 'language'])
            ->groupBy(fn($u) => in_array($u->language, $valid, true) ? $u->language : $default);

        foreach ($byLocale as $locale => $users) {
            $push->sendToUsers($users->pluck('id')->all(), [
                'title' => $this->planName !== ''
                    ? __t('text.backend.customer.push_title_plan', null, ['plan' => $this->planName], $locale)
                    : __t('text.backend.customer.push_title', null, [], $locale),
                'body'  => __t('text.backend.customer.push_body', null, [], $locale),
                'url'   => route('customer.home'),
                'tag'   => 'new-pick',
            ]);
        }
    }
}
