<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function create(Admin $admin)
    {
       return   $admin->hasPermissionTo('create_product');
    }
    public function update(Admin $admin, Product $product)
    {
        return  $admin->hasPermissionTo('edit_product');
    }

    public function delete(Admin $admin, Product $product)
    {
        return  $admin->hasPermissionTo('delete_product');
    }

    
}
