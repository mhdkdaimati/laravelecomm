<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

/*
*/
class PrductController extends Controller
{
    public function index(){
        $product = Product::all();

        return response()->json([
            'status'=>200,
            'product'=>$product,
        ]);

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [

            'name'=>'required|min:4|max:191',
            'description'=>' max:256',
            'meta_title'=>'max:191',
            'meta_keyword'=>'max:191',
            'meta_description'=>'max:256',
            'category_id'=>'required|max:191',
            'brand'=>'max:191',

            'selling_price'=>'max:191',
            'original_price'=>'max:191',
            'quantity'=>'max:191',
            'featured'=>'max:191',
            'popular'=>'max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'validator_errors'=>$validator->messages(),
            ]);
        }else{
            $product = new Product;

            $product->description = $request->input('description');
            $product->name = $request->input('name');
            $product->status = $request->input('status') == true ? '1':'0';
            $product->meta_title = $request->input('meta_title');
            $product->meta_keyword = $request->input('meta_keyword');
            $product->meta_description = $request->input('meta_description');
            $product->category_id = $request->input('category_id');
            $product->brand = $request->input('brand');
            $product->selling_price = $request->input('selling_price');
            $product->original_price = $request->input('original_price');
            $product->quantity = $request->input('quantity');
            $product->featured = $request->input('featured') == true ? '1':'0';
            $product->popular = $request->input('popular') == true ? '1':'0';
            //image
            if($request->hasFile('image')){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/product/',$filename);
                $product->image = 'uploads/product/'.$filename;

            }


            $product->save();

                    return response()->json([
                        'status'=>200,
                        'message'=>'Product Added Successfully',
                    ]);
                }


    }

    public function destroy($id){
        $product = Product::find($id);
        if($product){

            $product->delete();

            return response()->json([
                'status'=>200,
                'message'=>'Product Deleted Successfully',
            ]);

        }else{

            return response()->json([
                'status'=>404,
                'message'=>'No Product found',
            ]);

        }

    }
    public function edit($id){
        $product = Product::find($id);
        if($product){

            return response()->json([
                'status'=>200,
                'product'=>$product,
            ]);

        }else{

            return response()->json([
                'status'=>404,
                'message'=>'Invalid Product',
            ]);

        }

    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name'=>'required|min:4|max:191',
            'description'=>' max:256',
            'meta_title'=>'max:191',
            'meta_keyword'=>'max:191',
            'meta_description'=>'max:256',
            'category_id'=>'required|max:191',
            'brand'=>'max:191',
            'selling_price'=>'max:191',
            'original_price'=>'max:191',
            'quantity'=>'max:191',
            'featured'=>'max:191',
            'popular'=>'max:191',

        ]);
        if($validator->fails()){

            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }else{

            $product = Product::find($id);
            if($product){

                $product->description = $request->input('description');
                $product->name = $request->input('name');
                $product->meta_title = $request->input('meta_title');
                $product->meta_keyword = $request->input('meta_keyword');
                $product->meta_description = $request->input('meta_description');
                $product->category_id = $request->input('category_id');
                $product->brand = $request->input('brand');
                $product->selling_price = $request->input('selling_price');
                $product->original_price = $request->input('original_price');
                $product->quantity = $request->input('quantity');
                $product->featured = $request->input('featured');
                $product->popular = $request->input('popular');
                $product->status = $request->input('status');

                //image
                if($request->hasFile('image')){
                    $path = $product->image;
                    if(File::exists($path)){
                        File::delete($path);
                    }
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('uploads/product/',$filename);
                    $product->image = 'uploads/product/'.$filename;

                }
            $product->update();

            return response()->json([
                'status'=>200,
                'message'=>'Product Updated Successfully',
            ]);
        }else{

            return response()->json([
                'status'=>404,
                'message'=>'No Category found',
            ]);

        }
    }

}




}
