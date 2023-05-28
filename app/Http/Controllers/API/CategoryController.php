<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(){
        $category = Category::all();

        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);

    }
    public function allCategory(){
        $category = Category::where('status','0')->get();

        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name'=>'required|min:4|max:191|unique:categories,name',
            'description'=>'required|max:256|min:4',
            'meta_title'=>'required|min:4|max:191',
            'meta_keyword'=>'min:4|max:191',
            'meta_description'=>'required|min:4|max:256',
            'status'=>'max:2'

        ]);

        if($validator->fails()){
            return response()->json([
                'validator_errors'=>$validator->messages(),
            ]);
        }else{

                    $category = new Category;
                    $category->name = $request->input('name');
                    $category->description = $request->input('description');
                    $category->status = $request->input('status') == true ? '1':'0';
                    $category->meta_title = $request->input('meta_title');
                    $category->meta_keyword = $request->input('meta_keyword');
                    $category->meta_description = $request->input('meta_description');
                    $category->save();

                    return response()->json([
                        'status'=>200,
                        'message'=>'Category Added Successfully',
                    ]);
                }

    }

    public function edit($id){
        $category = Category::find($id);
        if($category){

            return response()->json([
                'status'=>200,
                'category'=>$category,
            ]);

        }else{

            return response()->json([
                'status'=>404,
                'message'=>'Invalid Category',
            ]);

        }

    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name'=>'required|min:4|max:191|unique:categories,name,'.$id.',id',
            'description'=>'required|max:256|min:4',
            'meta_title'=>'required|min:4|max:191',
            'meta_keyword'=>'min:4|max:191',
            'meta_description'=>'required|min:4|max:256',

        ]);
        if($validator->fails()){

            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);

        }else{

                    $category = Category::find($id);
                    if($category){

                    $category->name = $request->input('name');
                    $category->description = $request->input('description');
                    $category->status = $request->input('status') == true ? '1':'0';
                    $category->meta_title = $request->input('meta_title');
                    $category->meta_keyword = $request->input('meta_keyword');
                    $category->meta_description = $request->input('meta_description');
                    $category->save();

                    return response()->json([
                        'status'=>200,
                        'message'=>'Category Updated Successfully',
                    ]);
                    }else{

                    return response()->json([
                        'status'=>404,
                        'message'=>'No Category found',
                    ]);

                }
            }

    }
    public function destroy($id){
        $category = Category::find($id);
        if($category){

            $category->delete();

            return response()->json([
                'status'=>200,
                'message'=>'Category Deleted Successfully',
            ]);

        }else{

            return response()->json([
                'status'=>404,
                'message'=>'No Category found',
            ]);

        }

    }

}

