<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;

if (!function_exists("userSession")) {
    function userSession(){
        return User::where("id",Auth::user()->id)->first();
    }
}
