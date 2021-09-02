<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use modules\Admins\Models\Admin;
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
                         'create_product', 'edit_product','delete_product', 'view_product',
                          'create_order', 'edit_order', 'delete_order', 'view_order',
        ];
        foreach ($adminPermissions as $permission) {
            Permission::create(['name' => $permission,
            'guard_name' => 'admin'
            ]);
        }

    }
}
