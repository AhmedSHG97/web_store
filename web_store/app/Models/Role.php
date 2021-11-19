<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = "roles";
    
    protected $fillable = [
        "slug",
        "name",
    ];
    public function permissions(){
        return $this->belongsToMany(Permission::class,"roles_permissions");
    }
    public function users(){
        return $this->belongsToMany(User::class,"users_roles");
    }

    /**Start a function to give permissions to the role */
    public function givePermissionTo(... $permissions){
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null){
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }
    /**#End a function to give permissions to the role */

    /**Start a function to take permissions From the role */
    public function withdrawPermissionTo(... $permissions){
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }
    /**#End a function to take permissions From the role */

    /**Start a function to get opject of the permission model specified with a givin permission  */
    public function getAllPermissions(array $permissions){
        return Permission::whereIn('slug',$permissions)->get();
    }
    /**#End a function to get opject of the permission model specified with a givin permission  */
}
