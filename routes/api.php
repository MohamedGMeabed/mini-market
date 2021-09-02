<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'admin'],function(){
    Route::post('login',[AdminController::class,'login']);
  

});
Route::group(['prefix'=>'admin','middleware'=>'auth:sanctum'],function(){
    Route::post('create',[AdminController::class,'create']);
    Route::post('update/{admin}',[AdminController::class,'update']);
    Route::post('delete/{admin}',[AdminController::class,'delete']);
    Route::post('logout',[AdminController::class,'logout']);

});

Route::group(['prefix'=>'product','middleware'=>'auth:sanctum'],function(){
    Route::post('create',[ProductController::class,'create']);
    Route::post('update/{product}',[ProductController::class,'update']);
    Route::post('delete/{product}',[ProductController::class,'delete']);
    Route::get('all',[ProductController::class,'index']);

});
Route::group(['prefix'=>'cart','middleware'=>'auth:sanctum'],function(){
    Route::post('create',[CartController::class,'setItemCart']);
    Route::get('cart',[CartController::class,'getItemCart']);
});

Route::group(['prefix'=>'order','middleware'=>'auth:sanctum'],function(){
    Route::post('create',[OrderController::class,'createOrder']);
    Route::get('show',[OrderController::class,'showOrder']);
});

Route::post('login',[UserController::class,'login']);
