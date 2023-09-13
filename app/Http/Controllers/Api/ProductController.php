<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $prouducts = Product::all();
        return $prouducts;
    }
    public function show_archive()
    {
        $products = Product::onlyTrashed()->get();
        return $products;
    }
    public function store(Request $request)
    {
        $request->validate([
              'category_id' => 'required',
              'name' => 'required|min:4|max:255',
              'price' => 'required|integer',
              'image' => 'required_without:image_upload|string|nullable',
              'image_upload' => 'required_without:image|file|image|nullable',
              'expiry_date'=> 'date|string|nullable',
              'description' => 'required|min:4|max:255',
              'created_by' => 'required|max:255',

        ]);
        $product =new Product();
        if ($request->has('expiry_date')) {
            $product->expiry_date = date_create($request->expiry_date)->format('Y-m-d');
            if ($product->expiry_date <= Carbon::now()->format('Y-m-d')) {
                return "this product has finshed Expriate Date";
            }
        }
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->created_by = $request->created_by;
        if ($request->hasFile('image_upload')) {
            $image =$request->file('image_upload');
            $file_name = uniqid().$image->getClientOriginalName();
            $product->image = $file_name;
            $image->move(public_path('Api/Product-images/'), $file_name);
        //  $image =$request->file('image_upload')->storeAs('users',$file_name,'public');
        } else {
            $product->image = $request->image;
        }

        $product->save();
        return  response(
            [
            'Message'=>'The Product has been Add successfully',
            'Category'=>$product]
        );
    }
    public function update(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'category_id' => 'required',
            'name' => 'required|min:4|max:255',
            'price' => 'required|integer',
            'image' => 'required_without:image_upload|string|nullable',
            'image_upload' => 'required_without:image|file|image|nullable',
            'expiry_date'=> 'date|string|nullable',
            'description' => 'required|min:4|max:255',
            'created_by' => 'required|max:255',

      ]);
        $id =$request->id;
        $product =Product::find($id);
        if ($request->has('expiry_date')) {
            $product->expiry_date = date_create($request->expiry_date)->format('Y-m-d');
            if ($product->expiry_date <= Carbon::now()->format('Y-m-d')) {
                return "this product has finshed Expriate Date";
            }
        }
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->created_by = $request->created_by;
        if ($request->hasFile('image_upload')) {
            $image =$request->file('image_upload');
            $file_name = uniqid().$image->getClientOriginalName();
            $product->image = $file_name;
            $image->move(public_path('Api/Product-images/'), $file_name);
        //  $image =$request->file('image_upload')->storeAs('users',$file_name,'public');
        } else {
            $product->image = $request->image;
        }

        $product->update();
        return  response(
            [
            'Message'=>'The Product has been Add successfully',
            'Product'=>$product]
        );
    }
    public function archive(Request $request){
        $this->validate($request,['id'=>'required']);
        $id =$request->id;
        Product::find($id)->delete();
        return  response(
            [
                'Message'=>'The Product has been Move to archive successfully'
                ]
        );

    }
    public function destroy(Request $request){
        $request->validate(['id'=>'required']);
        $id = $request->id;
        $product = Product::onlyTrashed()->find($id);
        
        $filename = $product->image;
        $path = 'C:\xampp\htdocs\MyFirstApp\Company\public\Api\category-images\\'.$filename;
        if($filename)
            unlink($path);
        else
            return $path;
         
        $product->forceDelete();
        return  response(
            [
                'Message'=>'The Product has been Delete successfully',
                'Category'=>$product]
        );

//        if(Storage::exists($path)){
//            Storage::delete($path);
//        }else{
//            return $path;
//        }

    }
    public function move_From_archive(Request $request){

        $this->validate($request,[
            'id'=>'required'
        ]);

        $id =$request->id;
        Product::withoutTrashed()->where('id',$id)->restore();
        return response(['Message'=>'The Product has been Cancel The archive successfully ']);

    }
}