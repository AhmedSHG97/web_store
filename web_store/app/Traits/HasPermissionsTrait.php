<?php
namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

/**
 * trait to handel user relations in User Model
 */
trait HasPermissionsTrait
{
    /**Start a function to get all user permissions */
    public function permissions(){
        return $this->belongsToMany(Permission::class,"users_permissions");
    }
    /**#End a function to get all user permissions */

    /**Start a function to get all user roles */
    public function roles(){
        return $this->belongsToMany(Role::class,"users_roles");
    }
    /**#End a function to get all user roles */
    
    
    /**Start a function to give permissions to the user */
    public function givePermissionTo(... $permissions){
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null){
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }
    /**#End a function to give permissions to the user */

    /**Start a function to give role to the user */
    public function giveRoleTo(... $roles){
        $roles = $this->getAllRoles($roles);
        if($roles === null){
            return $this;
        }
        $this->roles()->saveMany($roles);
        return $this;
    }
    /**#End a function to give role to the user */

    /**Start a function to get opject of the permission model specified with a givin permission  */
    public function getAllPermissions(array $permissions){
        return Permission::whereIn('slug',$permissions)->get();
    }
    /**#End a function to get opject of the permission model specified with a givin permission  */

    /**Start a function to get opject of the Role model specified with a givin Role  */
    public function getAllRoles(array $roles){
        return Role::whereIn('slug',$roles)->get();
    }
    /**#End a function to get opject of the role model specified with a givin role  */
    
    /**Start a function to take permissions From the user */
    public function withdrawPermissionTo(... $permissions){
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }
    /**#End a function to take permissions From the user */

    /**Start a function to unassign roles From the user */
    public function withdrawRoleTo(... $roles){
        $roles = $this->getAllRoles($roles);
        $this->roles()->detach($roles);
        return $this;
    }
    /**#End a function to take permissions From the user */


    /**Start a function to chack of the use has the permission */
    public function hasPermissionTo($permission){
        if(is_object($permission)){
            return $this->hasPermissionThroughRole($permission);
        }
        return $this->hasPermission($permission);
       
    }
    /**#End a function to chack of the use has the permission */

    /**Start a function to chack of the use has the permission through the roles of usre and the permission roles  */
    public function hasPermissionThroughRole($permission){
        foreach($permission->roles as $role){
            if($this->roles->contains('slug',$role)){
                return true;
            }
        }
        return false;
    }
    /**#End a function to chack of the use has the permission through the roles of usre and  the permission roles  */
    
    /**Start a function to chack of the use has the permission */
    public function hasPermission($permission){
        return (bool) $this->permissions->where("slug",$permission)->count();
    }
    public function hasSingleRole($role){
        return (bool) $this->roles->where("slug",$role)->count();
    }
    /**#End a function to chack of the use has the permission */

    /**Start a function to check have the role or not */
    public function hasRole(... $roles){
        foreach($roles as $role){
            if($this->roles->contains('slug',$role)){
                return true;
            }
        }
        return false;
    }
    /**#End a function to check have the role or not */


}
