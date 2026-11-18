<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\UpdateExpiredSubscriptionsJob;
use App\Jobs\SendRenewalInvitationJob;

// Comandos personalizados
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ==========================================
// SCHEDULES
// ==========================================

// 1. Actualizar suscripciones vencidas - Todos los días a las 12 AM
Schedule::job(new UpdateExpiredSubscriptionsJob())
    ->dailyAt('00:00')
    ->name('update-expired-subscriptions')
    ->withoutOverlapping()
    ->onSuccess(function () {
        Log::info('UpdateExpiredSubscriptionsJob completado exitosamente');
    })
    ->onFailure(function () {
        Log::error('UpdateExpiredSubscriptionsJob falló');
    });

// Invitar a renovar a clientes con suscripción vencida - Todos los días a las 7 AM
Schedule::job(new SendRenewalInvitationJob())
    ->dailyAt('07:00')
    ->name('send-renewal-invitations')
    ->withoutOverlapping()
    ->onFailure(function () {
        Log::error('SendRenewalInvitationJob falló');
    });

// Invitar a los suscriptores gratis a comprar un plan - Todos los días a las 7 AM (cada persona recibe máximo 2 correos)
Schedule::job(new \App\Jobs\SendPlanInvitationJob())
    ->dailyAt('07:00')
    ->name('send-plan-invitations')
    ->withoutOverlapping()
    ->onFailure(function () {
        Log::error('SendPlanInvitationJob falló');
    });

// 2. Limpiar jobs fallidos antiguos - Diario a las 2 AM
// MEJORA: Usa prune-failed en lugar de flush para no borrar errores recientes
// El parámetro "48" significa que borra los que tengan más de 48 horas
Schedule::command('queue:prune-failed --hours=48')
    ->dailyAt('02:00')
    ->name('queue-prune-failed')
    ->withoutOverlapping();