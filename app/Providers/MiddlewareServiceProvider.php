<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Http\Middleware\AdminMiddleware;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Router $router)
    {
        // Registra o alias 'admin' para o AdminMiddleware
        $router->aliasMiddleware('admin', AdminMiddleware::class);
    }
}
