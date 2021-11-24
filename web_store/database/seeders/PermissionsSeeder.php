<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'إظهار المنتجات',
                'slug' => 'show-products'
            ],
            [
                'name' => 'تعديل المنتجات',
                'slug' => 'modify-products'
            ],
            [
                'name' => 'إظهار الأقسام',
                'slug' => 'show-categories'
            ],
            [
                'name' => 'تعديل الأقسام',
                'slug' => 'modify-categories'
            ],
            [
                'name' => 'إظهار المخازن',
                'slug' => 'show-inventories'
            ],
            [
                'name' => 'تعديل المخازن',
                'slug' => 'modify-inventories'
            ],
            [
                'name' => 'إظهار المستخدمين',
                'slug' => 'show-users'
            ],
            [
                'name' => 'تعديل المستخدمين',
                'slug' => 'modify-users'
            ],
            [
                'name' => 'إظهار الفواتير',
                'slug' => 'show-invoices'
            ],
            [
                'name' => 'تعديل الفواتير',
                'slug' => 'modify-invoices'
            ],
            [
                'name' => 'إظهار الخزنة',
                'slug' => 'show-safe'
            ],
            [
                'name' => 'تعديل الخزنة',
                'slug' => 'modify-safe'
            ],
            [
                'name' => 'إظهار الأحصائيات',
                'slug' => 'show-statistics'
            ],
            [
                'name' => 'تعديل الأحصائيات',
                'slug' => 'modify-statistics'
            ],
            
        ];
        foreach ($permissions as $permission){
            Permission::create($permission);
        }
    }
}
