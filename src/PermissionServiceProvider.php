<?php

namespace Cirs\PermissionPackage;

use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('studentPermission', function($app){
            return new StudentPermission;
        });
    }
}
