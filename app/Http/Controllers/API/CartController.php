<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;


class CartController extends Controller
{
    //addToCart
    public function addToCart(Request $request){
        if(auth('sanctum')->check()){

            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->product_id;
            $product_quantity = $request->product_quantity;

            $productCheck = Product::where('id',$product_id)->first();

            if($productCheck){
                if(Cart::where('product_id',$product_id)->where('user_id',$user_id)->exists()){

                    return response()->json([
                        'status'=>409,
                        'message'=>$productCheck->name . ' Already Added to Cart, for modification check Mycart.'
                    ]);


                }else{

                    $cartItem = new Cart;
                    $cartItem->user_id = $user_id;
                    $cartItem->product_id = $product_id;
                    $cartItem->product_quantity = $product_quantity;
                    $cartItem->save();


                    return response()->json([
                        'status'=>201,
                        'message'=>'Added to myCart'
                    ]);


                }

            }else{

            return response()->json([
                'status'=>404,
                'message'=>'Product Not Found'
            ]);

        }

        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Login or Register to add to Cart'
            ]);
        }
    }

    //viewCart
    public function viewCart(){
        if(auth('sanctum')->check()){

            $user_id = auth('sanctum')->user()->id;
            $cartItem = Cart::where('user_id',$user_id)->get();

            return response()->json([

                'status'=>200,
                'cart'=>$cartItem
            ]);
        }else{

            return response()->json([
                'status'=>401,
                'message'=>'Login to view myCart'
            ]);
        }
    }
    //updateQuantity
    public function updateQuantity($cart_id, $scope){
        if(auth('sanctum')->check()){

            $user_id = auth('sanctum')->user()->id;
            $cartItem = Cart::where('id',$cart_id)->where('user_id',$user_id)->first();

            if($scope == 'inc'){

                $cartItem->product_quantity = +1;

            }elseif($scope == 'dec'){

                $cartItem->product_quantity = -1;

            }
            $cartItem->update();
            return response()->json([
                'status'=>200,
                'message'=>'Quantity updated.'
            ]);

        }else{

            return response()->json([
                'status'=>401,
                'message'=>'Unauthorized.'
            ]);
        }


    }
    public function deleteCartItem($cart_id){


        if(auth('sanctum')->check()){

            $user_id = auth('sanctum')->user()->id;
            $cartItem = Cart::where('id',$cart_id)->where('user_id',$user_id)->first();

            if($cartItem){

                $cartItem->delete();

                return response()->json([
                    'status'=>200,
                    'message'=>'Cart Item removed.'
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Cart Item not found.'
                ]);
            }

        }else{

            return response()->json([
                'status'=>401,
                'message'=>'Unauthorized.'
            ]);
        }
    }
}
