<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\Settings\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WebPage\StaticPageController;
use App\Models\StaticPage;
use App\Http\Controllers\Dashboard\PickController;
use App\Http\Controllers\Dashboard\CheckoutController;
use App\Http\Middleware\ActiveSubscription;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TrackingController;

Auth::routes();

    Route::get('/picks', [PickController::class, 'index'])
        ->name('picks.index');
    
Route::middleware('auth')->group(function () {
    Route::get('/planes', [CheckoutController::class, 'plans'])
        ->name('plans');
    
    Route::post(
        '/checkout/whop/{plan}',
        [CheckoutController::class, 'create']
    )->name('checkout.whop');
    
// 2. Ruta opcional para cuando el usuario redirige de vuelta a tu web (Frontend)
    Route::get('/checkout/complete', [CheckoutController::class, 'complete'])
        ->name('checkout.complete');
    
    Route::get('/picks', [PickController::class, 'index'])
        ->middleware(ActiveSubscription::class)
        ->name('picks.index');
});


Route::get('/access-manager', [HomeController::class, 'formLogin'])->name('formLogin');

Route::get('/', function () {
    return view('frontend.principal');
})->name('show.principal');

Route::get('/how-it-works', function () {
    return view('frontend.how-it-works', ['classHowItWorks' => 'border-b-2 border-lime-400']);
})->name('show.how-it-works');

Route::get('/members', function () {
    return view('frontend.members', ['classMembers' => 'border-b-2 border-lime-400']);
})->name('show.members');

Route::get('/plans', function () {
    return view('frontend.plans', ['classPlans' => 'border-b-2 border-lime-400']);
})->name('show.plans');

Route::get('/login-customer', function () {
    return view('frontend.login-customer');
})->name('show.login-customer');

Route::get('/register', function () {
    return view('frontend.register');
})->name('show.register');

Route::get('/comments', function () {
    return view('frontend.comments');
})->name('show.comments');

Route::get('/recover-password', function () {
    return view('web_page.recover-password', ['classView' => 'login-body']);
})->name('show.recover.password');

Route::get('/mail-welcome', function () {
    return view('emails.welcome', );
})->name('show.recover.password');


Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'store')->name('store.register');
    Route::get('/verify-email', 'verifyEmail')->name('verify.email');
    Route::get('/confirmation-email', 'confirmationEmail')->name('confirmation.email');
    Route::post('/create-user-suscription', 'createUserSuscription')->name('create-user-suscription');
    Route::get('/send-mail-test', 'sendMailTest')->name('send-mail-test');
});

Route::controller(LoginController::class)->group(function () {
    Route::post('/verifylogin', 'authenticate')->name('verify.authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(StaticPageController::class)->group(function () {
    Route::get('/sports-news', 'getBlog')->name('show.sports-news');
    Route::get('/sports-news-detail/{source}', 'getBlogDetail')->name('show.sports-news-detail');
    Route::get('/terms-and-conditions', 'pageLegalDocuments')->name('show.terms-and-conditions')->defaults('type', StaticPage::class::TYPE_TERMS);
    Route::get('/who-we-are', 'pageLegalDocuments')->name('show.who-we-are')->defaults('type', StaticPage::class::TYPE_WHO_WE_ARE);
    Route::get('/frequently-asked-questions', 'frequentlyAskedQuestions')->name('show.frequently-asked-questions');
    Route::post('/save-comment', 'saveComment')->name('save.comment');
});

Route::get('lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/tracking/email-open', [TrackingController::class, 'emailOpen'])
    ->name('tracking.email-open')
    ->middleware('throttle:120,1');

include 'backend/admin.php';
include 'backend/dashboard.php';

