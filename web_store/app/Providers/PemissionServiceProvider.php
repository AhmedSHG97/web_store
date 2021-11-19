<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;

class PemissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission->slug);
                });
            });
        } catch (\Exception $e) {
            return false;
        }
    }
}
