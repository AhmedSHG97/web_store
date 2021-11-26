<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\Inventory\InventoryRepositoryInterface;
use App\Repositories\Inventory\InventoryRepository;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Permission\PermissionsRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Safe\SafeRepository;
use App\Repositories\Safe\SafeRepositoryInterface;
use App\Repositories\SafeTransactions\SafeTransactionRepository;
use App\Repositories\SafeTransactions\SafeTransactionRepositoryInterface;

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
            return "<?php if(Auth::user()->hasRole('admin') || Auth::user()->hasPermission($slug)){ ?>";
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
        Blade::directive('elserole', function ($slug) {
            return "<?php }else{ ?>";
        });

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(InventoryRepositoryInterface::class, InventoryRepository::class);
        $this->app->bind(PermissionsRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(SafeRepositoryInterface::class, SafeRepository::class);
        $this->app->bind(SafeTransactionRepositoryInterface::class, SafeTransactionRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
    }
}
