<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Cart;


class CheckoutController extends Controller
{
    //

    public function placeorder(Request $request){

        if(auth('sanctum')->check()){

            $validator = Validator::make($request->all(),[
                'firstname'=>'required|max:191',
                'lastname'=>'required|max:191',
                'phone'=>'required|max:191',
                'email'=>'required|max:191',
                'address'=>'required|max:191',
                'city'=>'required|max:191',
                'state'=>'required|max:191',
                'zipcode'=>'required|max:191',
            ]);

            if($validator->fails()){

                return response()->json([
                    'status'=>422,
                    'errors'=>$validator->messages()
                ]);

            }else{
                $user_id = auth('sanctum')->user()->id;
                $order = new Order;

                $order->user_id = $user_id;

                $order->firstname = $request->input('firstname');
                $order->lastname = $request->input('lastname');
                $order->phone = $request->input('phone');
                $order->email = $request->input('email');
                $order->address = $request->input('address');
                $order->city = $request->input('city');
                $order->state = $request->input('state');
                $order->zipcode = $request->input('zipcode');

                $order->payment_mode = 'COD';
                $order->traking_no = 'ecomm'.rand(1111,9999);
                $order->save();

                $cart = Cart::where('user_id',$user_id)->get();

                $ordertems = [];
                foreach($cart as $item){
                    $ordertems[] = [
                        'product_id'=>$item->product_id,
                        'quantity'=>$item->product_quantity,
                        'price'=>$item->product->selling_price,

                    ];
                    $item->product->update([
                        'quantity'=>$item->product->quantity - $item->product_quantity
                    ]);

                }
                $order->orderitems()->createMany($ordertems);

                Cart::destroy($cart);

                return response()->json([
                    'status'=>200,
                    'message'=>'Order placed successfully.'
                ]);

            }


        }else{

            return response()->json([
                'status'=>401,
                'message'=>'Login or Register to place an order'
            ]);

        }

    }
}
