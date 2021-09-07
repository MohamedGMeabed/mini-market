<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function create(Admin $admin)
    {
       return $admin->hasPermissionTo('create_admin');
    }
    public function edit(Admin $user,Admin $admin)
    { 
        return $user->id == $admin->id || $user->hasPermissionTo('edit_admin');
    }
    public function delete(Admin $user, Admin $admin)
    {
        return  $user->hasPermissionTo('delete_admin');
    }

}
