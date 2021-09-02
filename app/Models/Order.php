<?php

namespace App\Models;

use App\Events\OrderEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProduct;
/**
 *
 * @OA\Schema(
 *     required={"user_id","total","status"},
 *     @OA\Xml(name="Order"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="user_id", type="integer", readOnly="true",example="2"),
 *     @OA\Property(property="total", type="integer", readOnly="true", example="12000"),
 *     @OA\Property(property="status", type="enum", readOnly="true", format="password",example="mgm202025"),
 * )
 */
class Order extends Model
{
    use HasFactory;
    protected $dispatchesEvents = [
        'updated' => OrderEvent::class,
    ];


    protected $fillable = ['user_id','total','status'];

    protected $hidden = ['created_at','updated_at'];

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function orderProduct() {
        return $this->hasMany(OrderProduct::class,'order_id');
    }
}
