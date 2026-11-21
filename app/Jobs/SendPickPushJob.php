<?php

namespace App\Jobs;

use App\Services\User\WebPushServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/** Avisa por push (navegador) a los clientes a los que se les envió un pick. */
class SendPickPushJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries   = 1;

    public function __construct(protected array $userIds)
    {
        $this->onQueue('emails-picks');
    }

    public function handle(WebPushServices $push): void
    {
        $push->sendToUsers($this->userIds, [
            'title' => __t('text.backend.customer.push_title'),
            'body'  => __t('text.backend.customer.push_body'),
            'url'   => route('customer.home'),
            'tag'   => 'new-pick',
        ]);
    }
}
