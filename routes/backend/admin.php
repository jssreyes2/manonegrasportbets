<?php

use App\Http\Controllers\Admin\DashboardController;

//OPERACIONES
use App\Http\Controllers\Dashboard\SubscriptionController;
use App\Http\Controllers\Admin\Operations\PickController;
use App\Http\Controllers\TrackingController;

//CONETNIDO WEB
use App\Http\Controllers\Admin\WebContent\FrequentlyAskedQuestionController;
use App\Http\Controllers\Admin\WebContent\StaticPageController;

//MODULO DE AJUSTES
use App\Http\Controllers\Admin\ReportInvociceController;
use App\Http\Controllers\Admin\Settings\MenuController;
use App\Http\Controllers\Admin\Settings\SubMenuController;
use App\Http\Controllers\Admin\Settings\RolController;
use App\Http\Controllers\Admin\Settings\UserController;
use App\Http\Controllers\Admin\Settings\ParameterController;

//MODULO DE REGISTER
use App\Http\Controllers\Admin\Register\PlanController;
use App\Http\Controllers\Admin\Register\EntityController;

//MODULO DE CLIENTE
use App\Http\Controllers\Customer\ProfileCustomerController;

//MODULO DE REPORTES
use App\Http\Controllers\Admin\Reports\ReportUserController;


use App\Http\Controllers\Admin\UtilitiesController;
use Illuminate\Support\Facades\Route;
use App\Models\Rol;


Route::group(['prefix' => '/admin/', 'middleware' => ['auth']], function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('admin.panel');
    
    # #################################################################### OPERACIONES #############################################################################################
    ########### RUTAS PARA MODULO DE SUSCRIPCION ##########
    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('/get-subscriptions', 'getSubscription')->name('get.subscription')->middleware('check.rol.permissions:get.subscription');
        Route::get('/get-web-subscription', 'getWebSubscription')->name('get.web.subscription')->middleware('check.rol.permissions:get.web.subscription');
    });
    
    Route::controller(PickController::class)->group(function () {
        Route::get('/picks', 'index')->name('pick.index')->middleware('check.rol.permissions:pick.index');
        Route::post('/pick-create', 'create')->name('pick.create')->middleware('check.rol.permissions:pick.index');
        Route::post('/pick-edit', 'edit')->name('pick.edit')->middleware('check.rol.permissions:pick.index');
        Route::post('/pick-store', 'store')->name('pick.store');
        Route::post('/pick-update', 'update')->name('pick.update');
        Route::post('/pick-destroy', 'destroy')->name('pick.destroy');
        Route::post('/verify-pick', 'verifyPick')->name('verify.pick');
    });
    
    Route::controller(TrackingController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notification.index')->middleware('check.rol.permissions:notification.index');
    });
    #################################################################### FIN OPERACIONES #############################################################################################
    #
    # #################################################################### CONTENIDO WEB #############################################################################################
    Route::controller(FrequentlyAskedQuestionController::class)->group(function () {
        Route::get('/faqs', 'index')->name('faq.index')->middleware('check.rol.permissions:faq.index');
        Route::post('/faq-create', 'create')->name('faq.create')->middleware('check.rol.permissions:faq.index');
        Route::post('/faq-edit', 'edit')->name('faq.edit')->middleware('check.rol.permissions:faq.index');
        Route::post('/faq-store', 'store')->name('faq.store');
        Route::post('/faq-update', 'update')->name('faq.update');
        Route::post('/faq-destroy', 'destroy')->name('faq.destroy');
    });
    
    Route::controller(StaticPageController::class)->group(function () {
        Route::get('/static-pages', 'index')->name('staticpage.index')->middleware('check.rol.permissions:staticpage.index');
        Route::post('/static-page-create', 'create')->name('staticpage.create')->middleware('check.rol.permissions:staticpage.index');
        Route::post('/static-page-edit', 'edit')->name('staticpage.edit')->middleware('check.rol.permissions:staticpage.index');
        Route::post('/static-page-store', 'store')->name('staticpage.store');
        Route::post('/static-page-update', 'update')->name('staticpage.update');
        Route::post('/static-page-destroy', 'destroy')->name('staticpage.destroy');
        Route::get('/contacts', 'comments')->name('staticpage.contacts');
        Route::post('/contacts-response', 'commentResponse')->name('comment.response');
        Route::post('/send-response', 'sendResponse')->name('send.response');
    });
    
    
    #################################################################### FIN CONTENIDO WEB #############################################################################################
    #
    #
    #################################################################### REGISTROS ###################################################################################################
    
    ########### RUTAS PARA MODULO DE PLANES ##########
    Route::controller(PlanController::class)->group(function () {
        Route::get('/plans', 'index')->name('plan.index')->middleware('check.rol.permissions:plan.index');
        Route::post('/plan-create', 'create')->name('plan.create')->middleware('check.rol.permissions:plan.index');
        Route::post('/plan-edit', 'edit')->name('plan.edit')->middleware('check.rol.permissions:plan.index');
        Route::post('/plan-store', 'store')->name('plan.store');
        Route::post('/plan-update', 'update')->name('plan.update');
        Route::post('/plan-destroy', 'destroy')->name('plan.destroy');
    });
    
    #################################################################### FIN REGISTROS #############################################################################################
    #
    #
    #################################################################### REPORTES ###################################################################################################
    Route::controller(ReportUserController::class)->group(function () {
        Route::get('/get-report-customer', 'index')->name('get.report.user')->middleware('check.rol.permissions:get.report.user')->defaults('rol', Rol::ROL_CUSTOMER);
        Route::get('/excel-report-customer', 'exportExcelUser')->name('excel.report.customer')->defaults('rol', Rol::ROL_CUSTOMER);
        Route::get('/users-subscriptions', 'getUserSubscription')->name('get.user.subscription')->middleware('check.rol.permissions:get.user.subscription');
        Route::get('/excel-report-subscriptions', 'exportExcelSubscription')->name('excel.report.subscription');
    });
    #################################################################### FIN REPORTES #############################################################################################
    #
    #
    #################################################################### AJUSTES ###################################################################################################
    
    ########### RUTAS PARA MODULO DE MENU DE OPCIONES ##########
    Route::controller(MenuController::class)->group(function () {
        Route::get('/menus', 'index')->name('menu.index')->middleware('check.rol.permissions:menu.index');
        Route::post('/menus-create', 'create')->name('menu.create')->middleware('check.rol.permissions:menu.index');
        Route::post('/menus-edit', 'edit')->name('menu.edit')->middleware('check.rol.permissions:menu.index');
        Route::post('/menus-store', 'store')->name('menu.store');
        Route::post('/menus-update', 'update')->name('menu.update');
        Route::post('/menus-destroy', 'destroy')->name('menu.destroy');
    });
    
    ########### RUTAS PARA MODULO DE SUB MENU DE OPCIONES ##########
    Route::controller(SubMenuController::class)->group(function () {
        Route::get('/sub-menus', 'index')->name('submenu.index')->middleware('check.rol.permissions:submenu.index');
        Route::post('/sub-menus-edit', 'edit')->name('submenu.edit')->middleware('check.rol.permissions:submenu.index');
        Route::post('/sub-menus-update', 'update')->name('submenu.update');
        Route::post('/sub-menus-destroy', 'destroy')->name('submenu.destroy');
    });
    
    ########### RUTAS PARA MODULO DE ROLES ##########
    Route::controller(RolController::class)->group(function () {
        Route::get('/roles', 'index')->name('rol.index')->middleware('check.rol.permissions:rol.index');
        Route::post('/roles-create', 'create')->name('rol.create')->middleware('check.rol.permissions:rol.index');
        Route::post('/roles-edit', 'edit')->name('rol.edit')->middleware('check.rol.permissions:rol.index');
        Route::post('/roles-store', 'store')->name('rol.store');
        Route::post('/roles-update', 'update')->name('rol.update');
        Route::post('/roles-destroy', 'destroy')->name('rol.destroy');
    });
    
    ########### RUTAS PARA MODULO DE USUARIOS ##########
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('user.index')->middleware('check.rol.permissions:user.index');
        Route::post('/users-create', 'create')->name('user.create')->middleware('check.rol.permissions:user.index');
        Route::post('/users-edit', 'edit')->name('user.edit')->middleware('check.rol.permissions:user.index');
        Route::post('/users-store', 'store')->name('user.store');
        Route::post('/users-update', 'update')->name('user.update');
        Route::post('/users-destroy', 'destroy')->name('user.destroy');
    });
    
    ########### RUTAS PARA MODULO DE PARAMETROS ##########
    Route::controller(ParameterController::class)->group(function () {
        Route::get('/parameters', 'index')->name('parameter.index')->middleware('check.rol.permissions:parameter.index');
        Route::post('/parameter-store', 'store')->name('parameter.store');
        Route::post('/parameter-update', 'update')->name('parameter.update');
    });
    
    
    ############ UTILIDADES #############################
    Route::controller(UtilitiesController::class)->group(function () {
        Route::get('/match', 'utilityMatch')->name('utility.utilityMatch');
        Route::get('/utility-array', 'utilityArray')->name('utility.utilityArray');
        Route::get('/assign-points', 'assignPoints')->name('utility.assignPoint');
        Route::get('/assign-position', 'assignPosition')->name('utility.assignPosition');
    });
});
