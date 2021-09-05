<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiDesignTrait;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Cart;

use function PHPUnit\Framework\isEmpty;

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
    public function setCartItem(Request $request){
        $products = Product::where('id' ,'>' ,0)->pluck('id')->toArray();
        $customer_id = auth()->user()->id;
        $redis = Redis::connection();
        $cart = $request->all();
        $cartData =json_encode($cart['item']);  
        $cartItem = json_decode($cartData,true);
        $productDetails = []; 
        $array = [];
        foreach($cartItem as $itemDetail){
            $requestItem = explode(',', $itemDetail);
            $array[] =$requestItem[0];
            $productDetails[] =$requestItem;
            if(count($requestItem) != 3){
                return $this->ApiResponse(422, 'Error In Product', 'Enter All Product Data');
            }  
        } 
        if(array_unique($array) != $array){
            return $this->ApiResponse(422, 'Error In Product', 'Product IS Exist More Once');
        } 
        $diffId = array_diff($array,$products);
        if(!empty($diffId)){
            return $this->ApiResponse(422, 'Error In Product','Product ID Does Not Exists');
        }
        $cacheValue = $redis->set('cart_'.$customer_id,json_encode($cartItem));     
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
    
    public function getCartItem(){
        $customer_id = auth()->user()->id;
        $cartValue = Redis::get('cart_'.$customer_id);
        return  $this->ApiResponse(200,'Cart Data',null,json_decode($cartValue));
    }


      /**
     * @OA\post(
     *      path="/api/cart/delete",
     *      operationId="delete",
     *      tags={"Cart"},
     *      security={ {"sanctum": {} }},
     *      summary="Delete products From cart",
     *      description="Delete Cart",
     *      @OA\Response(
     *          response=200,
     *          description="Cart Item Deleted Successfully",
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
    public function deleteCartItem(){
        $customer_id = auth()->user()->id;
         Redis::del('cart_'.$customer_id);
        return  $this->ApiResponse(200,"Cart Item Deleted Successfully");
    }

}
