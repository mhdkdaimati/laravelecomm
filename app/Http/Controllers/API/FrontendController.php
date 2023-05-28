<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;



class FrontendController extends Controller
{
    public function category(){

        $category = Category::where('status','0')->get();
        return response()->json([
            'status'=>200,
            'category'=>$category
        ]);

    }

    public function product($category_id){

        $product = Product::where('category_id',$category_id)->get();
        $category = Category::select('name')->where('id',$category_id)->get()->first();


        if($product){

            return response()->json([
                'status'=>200,
                'product'=>$product,
                'category'=>$category,
            ]);

        }else{

            return response()->json([
                'status'=>404,
                'message'=>'Invalid Product',
            ]);

        }

    }
    public function viewProduct($category_id,$product_id){

        $product = Product::where('id',$product_id)->get()->first();
        $category = Category::select('name')->where('id',$category_id)->get()->first();


        if($product){

            return response()->json([
                'status'=>200,
                'product'=>$product,
                'category'=>$category,

            ]);
        }else{

            return response()->json([
                'status'=>404,
                'message'=>'Invalid Product',
            ]);

        }

    }
    public function allProduct(){

        $product = Product::where('status','0')->get();



        return response()->json([
            'status'=>200,
            'product'=>$product,
        ]);

    }

}
