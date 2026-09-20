<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

class DailyLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger('daily');
        
        // CORREGIDO: Convertir el nivel de string a entero de Monolog
        $level = $config['level'] ?? 'debug';
        $monologLevel = Logger::toMonologLevel($level);
        
        $handler = new RotatingFileHandler(
            storage_path('logs/laravel.log'),
            $config['days'] ?? 5,
            $monologLevel // ← Ahora es un entero, no un string
        );
        
        $handler->setFilenameFormat('laravel-{date}', 'Y-m-d');
        $logger->pushHandler($handler);
        
        return $logger;
    }
}