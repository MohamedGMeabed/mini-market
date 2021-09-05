<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {  
       return  $user->hasPermissionTo('create_order');
    }
    public function update(User $user, Order $order)
    {
        return  $user->hasPermissionTo('edit_order');
    }

    public function delete(User $user, Order $order)
    {
        return  $user->hasPermissionTo('delete_order');
    }
    public function view(User $user)
    {
        return  $user->hasPermissionTo('view_order');
    }
}
