<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
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
        $order = Order::where('user_id',auth()->user()->id)->where('status','Pending')->get();
        $Orderproducts =OrderProduct::whereHas('order',function($q){
            return $q->where('user_id',auth()->user()->id);})->get();
            
        return view('home',compact('Orderproducts','order'));
    }

    public function sendPushNotification($order_id,$status) {
        $order = Order::findOrFail($order_id);
        $order->status =$status;
        $order->save();
        $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
          
        $SERVER_API_KEY = 'AAAANQ3dcfc:APA91bGRrSw-b72GLaGhvOhPA2dPuMDN75tME3zT0DhywvJlS7zggeIerZENhOrqUFROMVO2yH2gWS-jt8YtB1-lQA1qU1VccIFWzqZqXnQdWHPEuV1CSAgzPNGX1HsLk-050NeFAz2M';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "success",
                "body" => auth()->user()->name . " Make Order Succesfully",  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
       //dd($response);
        return redirect()->route('home');
    } 

    public function savePushNotificationToken(Request $request)
    {
        auth()->user()->update(['fcm_token'=>$request->token]);
        
        return response()->json(['token saved successfully.']);
    }
}
