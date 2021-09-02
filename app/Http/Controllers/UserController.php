<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiDesignTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiDesignTrait;
    
    
     /**
     * @OA\Post(
     * path="/api/login",
     * summary="Login",
     * description="Login user and Create token",
     * operationId="login",
     * tags={"User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="store user data",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *     @OA\Property(property="email", type="email", format="email", example="admin@gmail.com"),
     *     @OA\Property(property="password", type="password", format="email", example="123456789"),
     *        )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *     ),
     * @OA\Response(
     *    response=404,
     *    description="Invalid Credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Invalid Credentials"),
     *    )
     * )
     * )
     */
    public function login(Request $request){
        $data = $request->validate([
                 'email' => 'required|email',
                 'password'=>'required'
              ]);
       $user= auth()->guard('user')->attempt($data);
       $user = User::where('email',$request->email)->first();
        if(!$user){
            return $this->ApiResponse(422,'user Does Not Exist');
        }
        if(Hash::check($request->password, $user->password) === false){
            return $this->ApiResponse(422,'Invalid Credentials');
        }
        $userToken = $user->createToken('token')->plainTextToken;
        return $this->ApiResponse(200,'You Are Login',null, $userToken);
  }

}
