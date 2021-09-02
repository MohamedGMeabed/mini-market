<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 *
 * @OA\Schema(
 *     required={"title","description","price","in_stock","price_after","vendor_id"},
 * @OA\Xml(name="Product"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="title", type="string", readOnly="true", example="Iphone 12"),
 *     @OA\Property(property="description", type="string", readOnly="true",description="Product description", example="New Technology"),
 *     @OA\Property(property="price", type="double", readOnly="true", example="111.00"),
 * )
 */
class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','price','image'];
    protected $hidden = ['created_at','updated_at'];

}
