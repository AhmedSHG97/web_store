<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

if (!function_exists("userSession")) {
    function userSession(){
        return User::where("id",Auth::user()->id)->first();
    }
}

if (!function_exists("activateTap")) {
    function activateTap($target_path,$target1 = null){
        if(request()->path() != null){
            if(request()->path() == $target_path){
                return "active";
            }
        }
        if($target1 != null){
            $target = explode('/',$target_path);
            $current = explode('/',request()->path());
            if(isset($current[1])){
                if(($current[1] == 'edit') && $current[0]."s" == $target[0]){
                    return "active";
                }else if(($current[1] == 'edit') && $current[0][strlen($current[0])-1] == 'y'){
                    $path = substr($current[0],0,-1);
                    if($path."ies" == $target1){
                        return "active";
                    }
                }
            }
            
        }
        
    }
}
if (!function_exists("activateList")) {
    function activateList($path,$path1){
        $current = explode('/',request()->path());
        if(($current[0] == $path || $current[0] == $path1)){
            return "active";
        }
    }
}
