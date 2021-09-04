<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use PayMob\Facades\PayMob;

class PayMobController extends Controller
{      
    public function index()
    {
        $customer = auth()->user();
        $orderData= Order::where('user_id',$customer->id)->where('status','pending')->first();
       $Orderproducts = OrderProduct::with(['order' => function($q){
          $q->where('user_id',auth()->user()->id );  }])->first();

        $auth = PayMob::AuthenticationRequest();
        $order = PayMob::OrderRegistrationAPI([
            'auth_token' => $auth->token,
            'amount_cents' => 100, //put your price
            'currency' => 'EGP',
            'delivery_needed' => false, // another option true
            'merchant_order_id' => now(), //put order id from your database must be unique id
            'items' => [[ // all items information
                "name" => "ASC1515",
                "amount_cents" =>100,
                "description" => "Smart Watch",
                "quantity" => $Orderproducts->quantity
            ]]
        ]);
        $PaymentKey = PayMob::PaymentKeyRequest([
            'auth_token' => $auth->token,
            'amount_cents' => 100 * $orderData->total, //put your price
            'currency' => 'EGP',
            'order_id' =>$order->id,
            "billing_data" => [ // put your client information
                "apartment" => "803",
                "email" => $customer->email,
               "floor" => "2",
                "first_name" => "MR",
                "street" => "Main Street",
                "building" => "14",
                "phone_number" => "01017205578",
                "shipping_method" => "PKG",
                // "postal_code" => "01898",
                "city" => "Bani Suef",
                "country" => "EG",
                "last_name" => $customer->name,
                // "state" => "Utah"
            ]
        ]);
        return view('paymob')->with(['token' => $PaymentKey->token]);
    }
}
