<?php

namespace App\Http\Controllers\Admin\Storehouse_mangament;

use App\Models\Product;
use App\Models\Storehouse_Product;
use App\Models\Storehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ProductsController extends Controller
{
   
    public function index()
    {
        return view('admin.storehouse_management.products.index');
    }

    public function data(){
         
       // $products = Product::whenCategoryId(request()->category_id)->with(['category']);
       $storehouses = Storehouse::all();
       //$products = $storehouses[0]->products;
       $storehouse_product = Storehouse_Product::where('storehouse_id',auth()->user()->storehouse->id)->get();//->where('product_id',$storehouses[0]->products->id); 
       $products = [];
       $i=0;
       foreach($storehouse_product as $p){
        $PId = $storehouse_product[$i]->product_id;
        $product =Product::find($PId);
        $product->number_boxes= $storehouse_product[$i]->number_boxes;
        $products[] =$product; 
        $i = $i+1;
       }
      
    // return $products;


       return DataTables::of($products)
            ->addColumn('record_select', 'admin.category.data_table.record_select')
            ->addColumn('image', function (Product $product) {
                return view('admin.product.data_table.image', compact('product'));
            })
            // ->addColumn('category', function (Product $product ) {
            //     return view('admin.product.data_table.category', compact('product'));
            // })
            ->editColumn('created_at', function (Product $product) {
                        return $product->created_at->format('Y-m-d');
                    })
                    ->addColumn('actions', 'admin.product.data_table.actions')
                    ->rawColumns(['record_select','actions'])
                    ->toJson();
                    
  //  return $product;
     }

    public function create()
    {
        $products =Product::all();
        return view('admin.storehouse_management.products.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // products
        $i=0;
        foreach($request->product_id as $Pid)
        {
            $storehouse_product = new Storehouse_Product();
            $product=Product::find($Pid);
            $product->number_boxes = $product->number_boxes + $request->boxes[$i];
            $product->update();
            $storehouse_product->storehouse_id = auth()->user()->storehouse->id;
            $storehouse_product->product_id = $product->id;
            $storehouse_product->number_boxes = $request->boxes[$i];
            $storehouse_product->save();
            $i = $i + 1;
        }

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.Storehouse_mangament.products.index');
            
        
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
