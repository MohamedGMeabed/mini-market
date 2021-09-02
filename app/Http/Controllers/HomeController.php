<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
/**
 * @OA\Get(
 *     path="/",
 *     description="Home page",
 *     @OA\Response(response="default", description="Welcome page")
 * )
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $order = Order::where('user_id',auth()->user()->id)->get();
        $Orderproducts = OrderProduct::with(['order' => function($q){
            $q->where('user_id',auth()->user()->id);}])->get();
        return view('home',compact('Orderproducts','order'));
    }

    public function editOrderStatus($order_id,$status) {
        $order = Order::findOrFail($order_id);
        $order->status =$status;
        $order->save();
        return redirect()->route('home');
    }  
}
