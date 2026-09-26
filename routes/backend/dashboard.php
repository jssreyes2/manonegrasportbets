<?php

use App\Http\Controllers\Dashboard\SubscriptionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PaymentController;

use Illuminate\Support\Facades\Route;

########### RUTAS PARA MODULO DE SUSCRIPCION ##########
Route::controller(SubscriptionController::class)->group(function () {
    Route::get('/subscription', 'subscription')->name('subscription')->middleware('check.rol.permissions:subscription');
    Route::get('/get-client-subscription', 'getClientSubscription')->name('get.client.subscription')->middleware('check.rol.permissions:get.client.subscription');
});

############ USER VENDEDOR #############################
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->name('profile')->middleware(['check.completed.subscription','check.rol.permissions:profile']);
    Route::post('/profile-update', 'updateProfile')->name('update.profile');
    
    Route::get('/change-password', 'changePassword')->name('change.password')->middleware(['check.rol.permissions:change.password', 'check.completed.subscription', 'check.completed.profile']);
    Route::post('/save-new-password', 'saveNewPassword')->name('save.new.password');
});

############ PAGOS #############################
Route::controller(PaymentController::class)->group(function () {
    Route::get('/my-payments', 'index')->name('my.payment')->middleware(['check.completed.subscription','check.rol.permissions:my.payment']);
    Route::get('/users-payments', 'index')->name('get.payment.user')->middleware(['check.rol.permissions:get.payment.user']);
});

