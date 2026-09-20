<?php

namespace App\Providers;

use App\Models\Parameter;
use App\Repositories\Settings\MenuRepository;
use App\Services\InvoiceServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('invoice', function ($app) {
            return new InvoiceServices();
        });
        
        // Registrar IDE Helper solo en entorno local
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts/app-backend', fn($v) => $v
            ->with('menus', MenuRepository::menus())
            ->with('route', Auth::user()?->rol_id == 3 ? 'subscription' : 'admin.panel')
        );
        
        view()->composer('layouts/app-backend', function ($view) {
            $view->with('parent', MenuRepository::getMenuParent(Auth::user()->rol_id));
        });
        
        view()->composer('layouts/footer', function ($view) {
            $view->with('parameter', Parameter::getParameter());
        });
        
        if (config('app.env') === 'local') {
            header("Access-Control-Allow-Origin: *");
        }
    }
}
