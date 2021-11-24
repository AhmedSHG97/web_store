<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create upper admin
        $admin_data = [
            'name' => "Supper Admin",
            'email' => "admin@admin.com",
            'password' => "123456",
        ];
        $admin = User::create($admin_data);
        
        //create role admin
        $role_data = ['slug' => "admin", 'name' => "administrator"];
        $role = Role::create($role_data);

        //save admin roles
        $admin->giveRoleTo($role->slug);

    }
}
