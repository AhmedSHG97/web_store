<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserAuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SafeController;
use App\Http\Controllers\SafeTransactionsController;
use App\Http\Middleware\Authentication;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([Authentication::class])->group(function () {
    /** Store controller routes */
    Route::get('/dashboard',[DashboardController::class,"show"]);
    /** END Store controller routes */

    /** Authentication routes*/
    Route::get("/logout",[UserAuthenticationController::class,"logout"])->name("logout");
    /** END Authentication routes*/
    
    
    /* User routes */
    Route::post("/user/delete",[UserController::class,"delete"])->name("deleteUser");
    Route::get("/user/edit/{id}",[UserController::class,"edit"]);
    Route::post("/user/update",[UserController::class,"update"])->name('updateUser');
    Route::post("user/permissions/update",[UserController::class,"updateUserPermissions"])->name('updateUserPermissions');
    /*END User routes */
    
    /* Invenory routes */
    Route::get("/inventories/all",[InventoryController::class,"all"]);
    Route::get("/inventory/create",[InventoryController::class,"create"]);
    Route::post("/inventory/store",[InventoryController::class,"store"])->name('storeInventory');
    Route::get("/inventory/edit/{id}",[InventoryController::class,"edit"]);
    Route::post("/inventory/update",[InventoryController::class,"update"])->name("updateInventory");
    Route::post("/inventory/delete",[InventoryController::class,"delete"])->name("deleteInventory");
    /* END Invenory routes */
    
    /* Category routes */
    Route::get("/categories/all",[CategoryController::class,"all"]);
    Route::get("/category/create",[CategoryController::class,"create"]);
    Route::post("/category/store",[CategoryController::class,"store"])->name('storeCategory');
    Route::get("/category/edit/{id}",[CategoryController::class,"edit"]);
    Route::post("/category/update",[CategoryController::class,"update"])->name("updateCategory");
    Route::post("/category/delete",[CategoryController::class,"delete"])->name("deleteCategory");
    /* END Category routes */

    /* Product routes */
    Route::get("/products/all",[ProductController::class,"all"]);
    Route::get("/product/create",[ProductController::class,"create"]);
    Route::post("/product/store",[ProductController::class,"store"])->name('storeProduct');
    Route::get("/product/edit/{id}",[ProductController::class,"edit"]);
    Route::post("/product/update",[ProductController::class,"update"])->name("updateProduct");
    Route::post("/product/delete",[ProductController::class,"delete"])->name("deleteProduct");
    Route::post("/product/filter",[ProductController::class,"productsFilter"])->name("productsFilter");
    Route::post("/product/store/excel",[ProductController::class,"storeExcel"])->name("storeExcel");
    /* END Product routes */

    /* Safe routes */
    Route::get("/safes/all",[SafeController::class,"all"]);
    Route::get("/safe/create",[SafeController::class,"create"]);
    Route::post("/safe/store",[SafeController::class,"store"])->name('storeSafe');
    Route::get("/safe/edit/{id}",[SafeController::class,"edit"]);
    Route::post("/safe/update",[SafeController::class,"update"])->name("updateSafe");
    Route::post("/safe/delete",[SafeController::class,"delete"])->name("deleteSafe");
    /* END Safe routes */

    /* Invoice routes */
    Route::get("/invoices/all",[InvoiceController::class,"all"]);
    Route::get("/invoice/create",[InvoiceController::class,"create"]);
    Route::post("/invoice/store",[InvoiceController::class,"store"])->name('storeInvoice');
    Route::post("/invoice/products/store",[InvoiceController::class,"storeInvoiceProducts"])->name('storeInvoiceProducts');
    Route::post("/invoice/delete",[InvoiceController::class,"delete"])->name("deleteInvoice");
    Route::get("/invoice/print/{id}",[InvoiceController::class,"print"]);
    /* END Invoice routes */

    /*Transactions */
    Route::post("/safe/transaction/store",[SafeTransactionsController::class,"store"])->name('storeTransaction');
    Route::post("/safe/transaction/delete",[SafeTransactionsController::class,"delete"])->name("deleteTransaction");
    /*END Transactions */

    //settings
    Route::get('settings/edit',[DashboardController::class,'editSettings']);
    Route::post('settings/update',[DashboardController::class,'updateSettings'])->name('updateSettings');
    
    


});

/** Authentication routes */
Route::get("/forgot/password",[UserAuthenticationController::class,"forgot"])->name("forgot");
Route::post("/forgot/password",[UserAuthenticationController::class,"resetPassword"])->name("resetPassword");
Route::get("/new/password/{token}",[UserAuthenticationController::class,"newPassword"])->name("newPassword");
Route::post("/change/password",[UserAuthenticationController::class,"changePassword"])->name("changePassword");
Route::get("/login",[UserAuthenticationController::class,"login"]);
Route::post("/signIn",[UserAuthenticationController::class,"signIn"])->name("signIn");
Route::get("/signUp",[UserAuthenticationController::class,"signUp"])->name("signUp");
Route::post("/register",[UserAuthenticationController::class,"register"])->name("register");
/** END Authentication routes */

