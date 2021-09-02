<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayMobController;
use App\Http\Controllers\SocialLoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/redirect/{driver}',[SocialLoginController::class,'redirectToSocial'])->name('login.social');
Route::get('/callback/{driver}',[SocialLoginController::class,'handleSocialCallback']);


Route::get('pay',[PayMobController::class,'index'])->name('payment');
Route::get('order-status/{order_id}/{status}',[HomeController::class, 'editOrderStatus'])->name('edit.status');

