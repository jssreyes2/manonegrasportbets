<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Matchable\Whop\Package\Events\WhopWebhookReceived;

class ProcessWhopWebhook
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    
    public function handle(WhopWebhookReceived $event): void
    {
        $payload = $event->payload;
        $action = $payload['action'] ?? null;
        $data = $payload['data'] ?? [];
        
        // Esto guardará los datos exactamente como llegan de Whop en tu archivo de logs
        Log::info('Webhook de Whop recibido:', [
            'action' => $action,
            'data' => $data
        ]);
        
        if ($action === 'payment.succeeded') {
            $orderId = $data['metadata']['order_id'] ?? null;
            $userId = $data['user'] ?? null;
            $amount = $data['final_amount'] ?? null;
            
            // Guarda o actualiza en tu BD aquí...
            Log::info("Pago exitoso procesado para la orden: {$orderId}");
        }
    }
}
