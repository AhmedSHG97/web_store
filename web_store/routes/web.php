<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserAuthenticationController;
use App\Http\Controllers\UserController;
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
    Route::post("/user/delete",[UserController::class,"delete"])->name("delete");
    /*END User routes */

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

