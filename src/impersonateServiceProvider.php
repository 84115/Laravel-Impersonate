<?php

namespace J84115\Impersonate;
 
use Illuminate\Support\ServiceProvider;
 
class ImpersonateServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }
 
    public function boot()
    {
        if (file_exists($helpers = __DIR__.'/helpers.php')) {
            require $helpers;
        }
    }
}
