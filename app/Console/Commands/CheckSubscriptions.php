<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\UpdateExpiredSubscriptionsJob;

class CheckSubscriptions extends Command
{
    protected $signature = 'check-subscriptions';
    protected $description = 'Verifica y actualiza suscripciones vencidas';
    
    public function handle()
    {
        try {
            Log::info("Iniciando actualización de suscripciones vencidas desde comando");
            
            // Instanciamos y ejecutamos el método handle directamente de forma sincrónica
            (new UpdateExpiredSubscriptionsJob())->handle();
            
            Log::info("Actualización de suscripciones completada correctamente");
            $this->info('Verificación y actualización ejecutada exitosamente');
            
            return 0;
            
        } catch (\Exception $e) {
            Log::error("Falló la verificación de suscripciones: " . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}