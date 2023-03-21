<?php

namespace J84115\Impersonate;
 
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use J84115\Impersonate\Http\Controllers\ImpersonateController;

class ImpersonateServiceProvider extends ServiceProvider
{
    public function register()
    {
        // 
    }
 
    public function boot(Router $router)
    {
        $router->middlewareGroup('impersonate', [ImpersonateMiddleware::class]);

        $router->macro('impersonate', function () use ($router) {
            $router->get(
                '/impersonate/login/{uid}',
                [ImpersonateController::class, 'login']
            )->name('impersonate.login');

            $router->get(
                '/impersonate/logout',
                [ImpersonateController::class, 'logout']
            )->name('impersonate.logout');
        });
    }
}
