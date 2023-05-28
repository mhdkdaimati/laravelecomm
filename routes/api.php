<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PrductController;
use App\Http\Controllers\API\FrontendController;
use App\Http\Controllers\API\CartController;
//CheckoutController
use App\Http\Controllers\API\CheckoutController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('getCategory',[FrontendController::class,'category']);
Route::get('getProduct/{category_id}',[FrontendController::class,'product']);
Route::get('viewProductDetails/{category_id}/{product_id}', [FrontendController::class,'viewProduct']);
//cart
Route::post('addToCart',[CartController::class,'addToCart']);

Route::get('cart',[CartController::class,'viewCart']);
//cart-updateQuantity
Route::put('cart-updateQuantity/{cart_id}/{scope}', [CartController::class,'updateQuantity']);
//delete-cartItem
Route::delete('delete-cartItem/{cart_id}', [CartController::class,'deleteCartItem']);
//search-product
Route::get('all-product',[FrontendController::class,'allProduct']);
//place-order
Route::post('place-order',[CheckoutController::class,'placeorder']);



Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function (){

    Route::get('/checkingAuthenticated', function(){
        return response()->json(['message'=>'in','status'=>200],200);
    });
    //category
    Route::post('store-category', [CategoryController::class, 'store']);

    Route::get('view-category', [CategoryController::class, 'index']);
    Route::get('edit-category/{id}', [CategoryController::class,'edit']);
    Route::put('update-category/{id}', [CategoryController::class,'update']);
    Route::delete('delete-category/{id}', [CategoryController::class,'destroy']);
    Route::get('all-category', [CategoryController::class,'allCategory']);
    //category end

    //product
    Route::post('store-product', [PrductController::class, 'store']);
    Route::get('view-product', [PrductController::class, 'index']);
    Route::delete('delete-product/{id}', [PrductController::class,'destroy']);
    Route::get('edit-product/{id}', [PrductController::class,'edit']);
    Route::post('update-product/{id}', [PrductController::class,'update']);



});

Route::middleware(['auth:sanctum'])->group(function (){

    Route::post('logout',[AuthController::class, 'logout']);

});
