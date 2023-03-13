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


        // TODO: tommorow
        // $router = $this->app['router'];
        // $router->macro('impersonate', function () use ($router) {
        //     $router->get(
        //         '/impersonate/take/{id}',
        //         '\J84115\Impersonate\Http\Controllers\ImpersonateController@take'
        //     )->name('impersonate.take');

        //     $router->get(
        //         '/impersonate/leave',
        //         '\J84115\Impersonate\Http\Controllers\ImpersonateController@leave'
        //     )->name('impersonate.leave');
        // });



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
