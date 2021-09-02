<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Redis;


class SocialLoginController extends Controller
{
    public function redirectToSocial($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function handleSocialCallback($driver)
    {
      try {
        $user = Socialite::driver($driver)->user();
        
        $this->registerOrLoginUser($user);

        return redirect()->route('home');

    } catch (Exception $exception) {
        dd($exception->getMessage());
    }
    }
    protected function registerOrLoginUser($request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->auth_token = $request->id;
            $user->avatar = $request->avatar;
            $user->password =Hash::make('123456789');
            $user->save();
        }

        Auth::login($user);
   
 }

}
