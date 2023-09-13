<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_product')->only(['index']);
        $this->middleware('permission:create_product')->only(['create', 'store']);
        $this->middleware('permission:update_product')->only(['edit', 'update']);
        $this->middleware('permission:delete_product')->only(['delete', 'bulk_delete']);

    }// end of __construct
    public function index()
    {
        $categories =Category::all();
       return view('admin.product.index',compact('categories'));
    }
    public function data(){
        $products = Product::whenCategoryId(request()->category_id)->with(['category']);
        return DataTables::of($products)
            ->addColumn('record_select', 'admin.category.data_table.record_select')
            ->addColumn('image', function (Product $product) {
                return view('admin.product.data_table.image', compact('product'));
            })
            ->addColumn('category', function (Product $product ) {
                return view('admin.product.data_table.category', compact('product'));
            })
            ->editColumn('created_at', function (Product $product) {
                        return $product->created_at->format('Y-m-d');
                    })
                     ->addColumn('actions', 'admin.product.data_table.actions')
                    ->rawColumns(['record_select','actions'])
                    ->toJson();



    }

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $product = Product::FindOrFail($recordId);
            $this->delete($product);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories =Category::all();
        return view('admin.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|min:4|max:255',
            'price' => 'required|integer',
            'number_boxes' => 'required|integer',
            'image' => 'required_without:image_upload|string|nullable',
            'image_upload' => 'required_without:image|file|image|nullable',
            'expiry_date'=> 'date|string|nullable',
            'description' => 'required|min:4|max:255',
      ]);
      $product =new Product();
        //   if ($request->has('expiry_date')) {
        //       $product->expiry_date = date_create($request->expiry_date)->format('Y-m-d');
        //       if ($product->expiry_date <= Carbon::now()->format('Y-m-d')) {
        //           return "this product has finshed Expriate Date";
        //       }
        //   }
      $product->expiry_date=$request->expiry_date;
      $product->category_id =$request->category_id;
      $product->name = $request->name;
      $product->price = $request->price;
      $product->number_boxes = $request->number_boxes;
      $product->description = $request->description;
      $product->created_by = auth()->user()->name;

      if ($request->hasFile('image_upload')) {
          $image =$request->file('image_upload');
          $file_name = uniqid().$image->getClientOriginalName();
          $product->image = $file_name;
          Storage::putFileAs('product_images', $image,$file_name);
      } else {
          $product->image = $request->image;
      }
    $product->save();
    session()->flash('success', __('site.added_successfully'));
    return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {   $categories =Category::all();
        return view('admin.product.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|min:4|max:255',
            'price' => 'required|integer',
            'nuber_boxes' =>
            'image', 
            'image_upload',
            'expiry_date'=> 'date|string|nullable',
            'description' => 'required|min:4|max:255',
    
      ]);
        
      if ($request->hasFile('image_upload')) {
        
        if (file_exists(public_path('Admin/product_images/'.$product->image))){
            $filedeleted = unlink(public_path('Admin/product_images/'.$product->image));
         } 
        $image =$request->file('image_upload');
        $file_name = uniqid().$image->getClientOriginalName();
        $product->image = $file_name; 
        Storage::putFileAs('product_images', $image,$file_name); 
    } 
    $product->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {   
        if (file_exists(public_path('Admin/product_images/'.$product->image))){
        $filedeleted = unlink(public_path('Admin/product_images/'.$product->image));
          } 
          if($filedeleted)
             $this->delete($product);
             session()->flash('success', __('site.deleted_successfully'));
             return response(__('site.deleted_successfully'));
    }
    public function delete(Product $product){
        $product->delete();


    }
}
