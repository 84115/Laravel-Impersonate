<?php

namespace J84115\Impersonate;
 
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class STANDARD {}

class ImpersonateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(STANDARD::class, function ($app) {
            return new STANDARD;
        });
    }
 
    public function boot(Router $router)
    {
        $router->middlewareGroup('impersonate', [ImpersonateMiddleware::class]);

        // if (file_exists($middleware = __DIR__.'/middleware.php')) {
        //     require $middleware;
        // }

        // if (file_exists($controller = __DIR__.'/controller.php')) {
        //     require $controller;
        // }
    }

    // public function provides()
    // {
    //     return [STANDARD::class];
    // }
}
