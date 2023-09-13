<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
 
    public function index(){
        $categories = Category::all();
        return $categories;
    }
    public function show_archive()
    {
        $categories = Category::onlyTrashed()->get();
        return $categories;
    }
    public function store(Request $request){

        $request->validate(
          [
              'name' => 'required|min:4|max:255',
              'image' => 'required_without:image_upload|string|nullable',
              'image_upload' => 'required_without:image|file|image|nullable',
              'description' => 'required|min:4|max:255',
              'created_by' => 'required|max:255',
          ]
        );
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->created_by = $request->created_by;
        if ($request->hasFile('image_upload')) {
            $image =$request->file('image_upload');
            $file_name = uniqid().$image->getClientOriginalName();
            $category->image = $file_name;
            $image->move(public_path('Api/category-images/'),$file_name);
          //  $image =$request->file('image_upload')->storeAs('users',$file_name,'public');
            
        } else {
            $category->image = $request->image;
        }
       
        $category->save();
        return  response(
            [
            'Message'=>'The Category has been Add successfully',
            'Category'=>$category]
        );
    }
    public function update(Request $request){

        $request->validate(
            [
                'id' => 'required|integer',
                'name' => 'required|min:4|max:255',
                'image' => 'required_without:image_upload|url|nullable',
                'image_upload' => 'required_without:image|file|image|nullable',
                'description' => 'required|min:4|max:255',
                'created_by' => 'required|max:255',
            ]
        );

        $id = $request->id;
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->created_by = $request->created_by;
        if ($request->hasFile('image_upload')) {
            $image =$request->file('image_upload');
            $file_name = uniqid().$image->getClientOriginalName();
            $image->move(public_path('Api/category-images/'),$file_name);
            
            $path = $file_name;
            $category->image = $path;

        } else {
            $category->image = $request->image;
        }
        
        $category->update();
        return  response(
            [
                'Message'=>'The Category has been Update successfully',
                'Category'=>$category]
        );
    }
    public function archive(Request $request){
        $this->validate($request,['id'=>'required']);
        $id =$request->id;
        Category::find($id)->delete();
        return  response(
            [
                'Message'=>'The Category has been Move to archive successfully'
                ]
        );

    }

    public function destroy(Request $request){
        $request->validate(['id'=>'required']);
        $id = $request->id;
        $category = Category::onlyTrashed()->find($id);
        
        $filename = $category->image;
        $path = 'C:\xampp\htdocs\MyFirstApp\Company\public\Api\category-images\\'.$filename;
        if($filename)
            unlink($path);
        else
            return $path;
         
        $category->forceDelete();
        return  response(
            [
                'Message'=>'The Category has been Delete successfully',
                'Category'=>$category]
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
        Category::withoutTrashed()->where('id',$id)->restore();
        return response(['Message'=>'The Category has been Cancel The archive successfully ']);

    }
    public function get_products(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);
        
        $id = $request->id;
        $category = Category::find($id);
        $products =[];
        foreach($category->products as $product){
            $products[] = $product;
        }
        return response(['Message'=>'Poducts','date'=>$products]);

    }


}
