<?php

namespace App\Providers;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\UserRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //roles directives
        Blade::directive('role', function ($slug) {
            return "<?php if(Auth::user()->hasRole($slug)){ ?>";
        });
        Blade::directive('endrole', function ($slug) {
            return "<?php } ?>";
        });
        //permission directives
        Blade::directive('permission', function ($slug) {
            return "<?php if(Auth::user()->hasPermission($slug)){ ?>";
        });
        Blade::directive('endpermission', function ($slug) {
            return "<?php } ?>";
        });

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
