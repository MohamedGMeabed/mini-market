<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiDesignTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Cart;
class CartController extends Controller
{
    use ApiDesignTrait;
 
    
     /**
     * @OA\Post(
     * path="/api/cart/create",
     * summary="new cart",
     * description="view product in cart",
     * operationId="create",
     * tags={"Cart"},
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Create new product",
     *    @OA\JsonContent(
     *           @OA\Property(property="item", type="array",
     *          @OA\Items(
     *              ),
     *           ),
     *           ),
     *      ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Cart created Successfully")
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Invalid Data",
     *    @OA\JsonContent(
     *       @OA\Property(property="error", type="string", example="Invalid Data")
     *        )
     *     )
     * )
     *
     */
    public function setItemCart(Request $request){
        $customer_id = auth()->user()->id;
        $redis = Redis::connection();
        $cart = $request->all();
        $cartData = $cart['item'];
        $cacheValue = $redis->set('cart_'.$customer_id,json_encode($cartData));     
        return $this->ApiResponse(200,'Data',Null,$cacheValue);
    }
     /**
     * @OA\Get(
     *      path="/api/cart/cart",
     *      operationId="index",
     *      tags={"Cart"},
     *      security={ {"sanctum": {} }},
     *      summary="Get list of products Details in cart",
     *      description="Returns list of product Data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    
    public function getItemCart(){
        $customer_id = auth()->user()->id;
        $cartValue = Redis::get('cart_'.$customer_id);
        return  $this->ApiResponse(200,'Cart Data',null,json_decode($cartValue));
        }

}
