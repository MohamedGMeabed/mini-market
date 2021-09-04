<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminPermissions = ['create_admin', 'edit_admin', 'delete_admin', 'view_admin',
                        'create_user', 'edit_user', 'delete_user', 'view_user',
                         'create_product', 'edit_product','delete_product'
        ];
        foreach ($adminPermissions as $adminpermission) {
            Permission::create(['name' => $adminpermission,
            'guard_name' => 'admin'
            ]);
        }
        
        $superAdmin = Admin::find(1);
        $superAdmin->givePermissionTo(Permission::all());

        

        $userPermissions = ['create_order', 'edit_order', 'delete_order', 'view_order',
                            'create_cart','delete_cart','edit_cart'];

        foreach ($userPermissions as $userpermission) {
            Permission::create(['name' => $userpermission,
            'guard_name' => 'user'
            ]);
        }

    }
}
