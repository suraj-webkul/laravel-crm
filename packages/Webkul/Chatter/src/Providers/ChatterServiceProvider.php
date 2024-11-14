<?php

namespace Webkul\Chatter\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ChatterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        Route::middleware(['web', 'admin_locale', 'user'])
            ->prefix(config('app.admin_path'))
            ->group(__DIR__.'/../Routes/web.php');

        $this->app->register(ModuleServiceProvider::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {}
}
