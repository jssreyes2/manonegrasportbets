<?php

namespace App\Providers;

use App\Models\Parameter;
use App\Models\Rol;
use App\Services\User\CustomerPanelServices;
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
            ->with('route', Auth::user()?->rol_id == 3 ? 'customer.home' : 'admin.panel')
        );

        // Aviso en todas las páginas del cliente cuando un plan vence en los próximos días
        view()->composer('layouts/app-backend', function ($view) {
            $isCustomer = Auth::user()?->rol_id == Rol::ROL_CUSTOMER;

            $view->with('expiringPlans', $isCustomer
                ? rescue(fn() => app(CustomerPanelServices::class)->activePlans()->where('expiring', true), collect(), false)
                : collect());
        });
        
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
