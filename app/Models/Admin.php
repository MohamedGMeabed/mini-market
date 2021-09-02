<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

/**
 *
 * @OA\Schema(
 *     required={"name","email","password"},
 *     @OA\Xml(name="Admin"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="email", type="string", readOnly="true", format="email", description="Admin unique email address", example="Admin@gmail.com"),
 *     @OA\Property(property="name", type="string", readOnly="true", example="Super Admin"),
 *     @OA\Property(property="password", type="string", readOnly="true", format="password",example="mgm202025"),
 * )
 */
class Admin extends Authenticatable
{
    use HasFactory, HasRoles, HasApiTokens;
    protected $guard_name = 'admin';

    protected $fillable = ['name','email','password'];

    protected $hidden = ['password','created_at','updated_at'];
}
