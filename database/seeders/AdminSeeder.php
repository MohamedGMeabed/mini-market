<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $superAdmin =  Admin::create([
                        'name' => "Super admin",
                        'email' =>'admin@gmail.com',
                        'password' =>Hash::make('123456789'),
                    ]);

        $roles = ['super_admin', 'admin'];
        foreach($roles as $role){
            Role::create([
                'name' => $role,
                'guard_name' => 'admin'
            ]);
        }

        $roleUSer = Role::create([
                    'name' => 'user',
                    'guard_name' => 'user'
                ]);

        $roleAdmin = Role::first();
        $superAdmin->assignRole($roleAdmin);

       
    
       
        
    }
    
}
