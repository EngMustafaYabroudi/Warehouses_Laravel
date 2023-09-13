<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_category')->only(['index']);
        $this->middleware('permission:create_category')->only(['create', 'store']);
        $this->middleware('permission:update_category')->only(['edit', 'update']);
        $this->middleware('permission:delete_category')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
       return view('admin.category.index');
    }
    public function data(){
            $categories = Category::select();
            return DataTables::of($categories)
            ->addColumn('record_select', 'admin.category.data_table.record_select')
            ->addColumn('image', function (Category $category) {
                return view('admin.category.data_table.image', compact('category'));
            })
            ->addColumn('products', 'admin.category.data_table.products')
            ->editColumn('created_at', function (Category $category) {
                        return $category->created_at->format('Y-m-d');
                    })
                     ->addColumn('actions', 'admin.category.data_table.actions')
                    ->rawColumns(['record_select','products','actions'])
                    ->toJson();

    }
    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $category = Category::FindOrFail($recordId);
            $this->delete($category);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|min:4|max:255',
                'image' => 'required_without:image_upload|string|nullable',
                'image_upload' => 'required_without:image|file|image|nullable',
                'description' => 'required|min:4|max:255',
            ]
          );
          $category = new Category();
          $category->name = $request->name;
          $category->description = $request->description;
          $category->created_by = auth()->user()->name;//$request->created_by;
          if ($request->hasFile('image_upload')) {
              $image =$request->file('image_upload');
              $file_name =uniqid().$image->getClientOriginalName();
              $category->image = $file_name;
              Storage::putFileAs('category_images', $image,$file_name);
              
             //  Storage::put(public_path('Api/category_images'), $image, 'public');
            //  $image->move(public_path('Api/category-images/'),$file_name);
            //  $image->storeAs('category_images',$file_name,'Admin');
            
            // Storage::disk('Admin')->put($file_name, $image);
              
          } else {
              $category->image = $request->image;
             
          }
         
          $category->save();
  

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {   
        $request->validate(
            [
                'name' => 'required|min:4|max:255',
                'description' => 'required|min:4|max:255',
                'image',
                'image_upload'
            ]
        );
        if ($request->hasFile('image_upload')) {
            
            if (file_exists(public_path('Admin/category_images/'.$category->image))){
                $filedeleted = unlink(public_path('Admin/category_images/'.$category->image));
             } 
            $image =$request->file('image_upload');
            $file_name = uniqid().$image->getClientOriginalName();
            $category->image = $file_name;
            Storage::putFileAs('category_images', $image,$file_name); 
        } 
        $category->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {   
        if (file_exists(public_path('Admin/category_images/'.$category->image))){
            $filedeleted = unlink(public_path('Admin/category_images/'.$category->image));
         } 
         if($filedeleted)
            $this->delete($category);
            session()->flash('success', __('site.deleted_successfully'));
            return response(__('site.deleted_successfully'));

    }
    public function delete(Category $category){
        $category->forceDelete();
    }
}
