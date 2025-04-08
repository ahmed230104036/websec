<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
{
    if (!app()->runningInConsole() && $this->app->running()) {
        try {
            Permission::get();
        } catch (\Throwable $e) {
            // silently fail
        }
    }
}

} 