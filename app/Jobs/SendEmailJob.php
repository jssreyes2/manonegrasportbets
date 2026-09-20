<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\SendMailServices;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $data;
    
    public $timeout = 50;
    public $tries   = 3;
    public $backoff = [60, 300, 900];
    
    public function __construct(array $data)
    {
        $this->data = $data;
        //$this->queue = 'email-notifications';
    }
    
    public function handle(): void
    {
        try {
            // Validación básica
            if (empty($this->data['email'])) {
                Log::error('Email no proporcionado en SendEmailJob');
                return; // No reintentar
            }
            
            $mailService = app(SendMailServices::class); // Usar el contenedor
            $result = $mailService->sendMailNotification($this->data);
            
            if (!$result) {
                throw new \RuntimeException('Falló el envío de email');
            }
            
        } catch (\Exception $e) {
            Log::error('Error en SendEmailJob', [
                'email' => $this->data['email'] ?? 'desconocido',
                'error' => $e->getMessage(),
                'intento' => $this->attempts()
            ]);
            
            throw $e;
        }
    }
    
    public function failed(\Throwable $exception): void
    {
        Log::error('SendEmailJob falló definitivamente', [
            'email' => $this->data['email'] ?? 'desconocido',
            'error' => $exception->getMessage()
        ]);
    }
}