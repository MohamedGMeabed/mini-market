<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Traits\ApiDesignTrait;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use ApiDesignTrait;
    /**
     * @OA\Get(
     *      path="/api/product/all",
     *      operationId="index",
     *      tags={"Product"},
     *      security={ {"sanctum": {} }},
     *      summary="Get list of products",
     *      description="Returns list of product Data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *              @OA\Property(property="products", type="object", ref="#/components/schemas/Product"),
     *          )
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
    public function index()
    {
        $products = Product::all();
        return $this->ApiResponse(200,"All Products",Null,$products);
    }
      /**
     * @OA\Post(
     * path="/api/product/create",
     * summary="new product",
     * description="create new product",
     * operationId="create",
     * tags={"Product"},
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Create new product",
     *    @OA\JsonContent(
     *           required={"title","description","price"},
     *          @OA\Property(property="title", type="string", example = "iphone 13"),
     *          @OA\Property(property="description", type="string", example = "New Technology"),
     *          @OA\Property(property="price", type="double", example = "12000"),
     *           ),
     *      ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="product created Successfully")
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
   public function create(StoreProduct $request){
       $this->authorize('create',Product::class);
        $product = Product::create($request->all());
        return $this->ApiResponse(200, "Product created successfully", null, $product);
   }
     /**
     * @OA\post (
     * path="/api/product/update/{product}",
     * summary="update existing product",
     * description="update product",
     * operationId="update",
     * tags={"Product"},
     * security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="product",
     *          description="product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="update product name",
     *    @OA\JsonContent(
     *           required={"title","description","price"},
     *          @OA\Property(property="title", type="string", example = "iphone 13"),
     *          @OA\Property(property="description", type="string", example = "New Technology"),
     *          @OA\Property(property="price", type="double", example = "12000"),
     *           ),
     *      ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="product", type="object", ref="#/components/schemas/Product"),
     *         @OA\Property(property="message", type="string", example="product updated")
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="invalid input",
     *    @OA\JsonContent(
     *       @OA\Property(property="validation error", type="string", example="Sorry, invalid product name")
     *        )
     *     )
     * )
     *
     */
    public function update(Product $product, StoreProduct $request)
    {
        $this->authorize('edit',$product);
        $product->update($request->all());
        return $this->ApiResponse(200, "Product Updated successfully", null, $product);
    }
     
 /**
     * @OA\post(
     *      path="/api/product/delete/{product}",
     *      operationId="destroy",
     *      tags={"Product"},
     *      summary="Delete existing product",
     *      description="Delete existing product ",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="product",
     *          description="product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example="product Deleted Successfully"),
     *           ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *
     */
    public function delete(Product $product)
    {
        $this->authorize('delete',$product);
        if (! $product) {
            return $this->ApiResponse(200, "Product Not Found");
        }
        $product->delete();
        return $this->ApiResponse(200, "Product Deleted successfully");
    }
}
