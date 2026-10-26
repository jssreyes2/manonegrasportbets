<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\Settings\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WebPage\StaticPageController;
use App\Models\StaticPage;
use App\Models\FrequentlyAskedQuestion;
use App\Models\Plan;
use App\Models\Pick;
use App\Models\Comment;
use App\Models\HeroBanner;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Dashboard\PickController;
use App\Http\Controllers\Dashboard\CheckoutController;
use App\Http\Controllers\Dashboard\CustomerHomeController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TrackingController;

Auth::routes();

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
    
    // Inicio del cliente e historial de picks: visibles aunque no tenga plan activo (muestran cómo comprar uno)
    Route::get('/my-home', [CustomerHomeController::class, 'index'])
        ->middleware('check.completed.profile')
        ->name('customer.home');

    Route::get('/picks', [PickController::class, 'index'])
        ->middleware('check.completed.profile')
        ->name('picks.index');

    Route::post('/profile-preferences', [ProfileController::class, 'savePreferences'])
        ->name('profile.preferences');

    Route::get('/my-payments/{paymentId}/receipt', [PaymentController::class, 'receipt'])
        ->name('my.payment.receipt');
});


Route::get('/access-manager', [HomeController::class, 'formLogin'])->name('formLogin');

// FAQs destacadas para las landings; si la BD falla la página se muestra igual
$landingFaqs = fn() => rescue(
    fn() => FrequentlyAskedQuestion::where('is_active', true)
        ->where('language', session_language())
        ->orderBy('orden')
        ->take(5)
        ->get(),
    collect(),
);

// Planes activos (mismos que la vista Suscripción del panel). Sin select de columnas
// ni orden por `language`: así no falla si la tabla de producción no tiene alguna.
$activePlans = fn() => rescue(
    fn() => Plan::where('is_active', true)->orderBy('price')->get(),
    function (Throwable $e) {
        Log::error('Landing: no se pudieron cargar los planes activos', ['error' => $e->getMessage()]);
        return collect();
    },
    false,
);

// Historial real de picks calificados desde el 1 de enero del año en curso (acierto 30 días / del año y últimos resultados)
$pickResults = fn() => rescue(fn() => [
    'since'  => $since = now()->startOfYear(),
    'month'  => Pick::resultsSummary(30, null, $since),
    'all'    => Pick::resultsSummary(null, null, $since),
    'latest' => Pick::latestGraded(6, $since),
], null, false);

// Comentarios que el admin publicó como testimonio
$testimonials = fn() => rescue(fn() => Comment::testimonials(), collect(), false);

Route::get('/', function () use ($landingFaqs, $activePlans, $pickResults, $testimonials) {
    return view('frontend.principal', [
        'faqs'         => $landingFaqs(),
        'activePlans'  => $activePlans(),
        'results'      => $pickResults(),
        'testimonials' => $testimonials(),
        'hero'         => HeroBanner::current(),
        // El banner solo dice "picks publicados" si hoy ya salió un pick de suscripción
        'picksPublishedToday' => rescue(fn() => Pick::where('source', Pick::SOURCE_SUSCRIPTION)
            ->whereDate('created_at', today())
            ->exists(), false, false),
    ]);
})->name('show.principal');

Route::get('/how-it-works', function () {
    return view('frontend.how-it-works', ['classHowItWorks' => 'border-b-2 border-lime-400']);
})->name('show.how-it-works');

Route::get('/members', function () {
    return view('frontend.members', ['classMembers' => 'border-b-2 border-lime-400']);
})->name('show.members');

Route::get('/plans', function () use ($landingFaqs, $activePlans, $pickResults) {
    return view('frontend.plans', [
        'classPlans'  => 'border-b-2 border-lime-400',
        'faqs'        => $landingFaqs(),
        'activePlans' => $activePlans(),
        'results'     => $pickResults(),
    ]);
})->name('show.plans');

Route::get('/login-customer', function () {
    return view('frontend.login-customer');
})->name('show.login-customer');

Route::get('/register', function () {
    // Términos en el idioma actual, para leerlos en un modal sin salir del formulario
    $terms = rescue(fn() => StaticPage::where('type', StaticPage::TYPE_TERMS)
        ->where('language', session_language())
        ->where('is_active', true)
        ->first(), null, false);

    return view('frontend.register', compact('terms'));
})->name('show.register');

Route::get('/comments', function () {
    return view('frontend.comments');
})->name('show.comments');

// Enlace antiguo: la recuperación vive en las rutas de Auth::routes()
Route::redirect('/recover-password', '/password/reset')->name('show.recover.password');

Route::get('/check-your-email', function () {
    return view('frontend.check-email', ['email' => session('registered_email')]);
})->name('show.check-email');


Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'store')->name('store.register');
    Route::get('/verify-email', 'verifyEmail')->name('verify.email');
    Route::get('/confirmation-email', 'confirmationEmail')->name('confirmation.email');
    Route::post('/create-user-suscription', 'createUserSuscription')->name('create-user-suscription');
    Route::post('/resend-verification', 'resendVerification')->name('resend.verification')->middleware('throttle:3,10');
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

