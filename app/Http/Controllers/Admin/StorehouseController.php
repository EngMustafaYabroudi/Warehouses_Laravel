<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Product;
use App\Models\Storehouse;
use App\Models\Storehouse_Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class StorehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_storehouses')->only(['index']);
        $this->middleware('permission:create_storehouses')->only(['create', 'store']);
        $this->middleware('permission:update_storehouses')->only(['edit', 'update']);
        $this->middleware('permission:delete_storehouses')->only(['delete', 'bulk_delete']);

    }// end of __construct
    public function index()
    {
        return view('admin.storehouses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
    {
        $users = User::where('type','administrator')->get();
        return view('admin.storehouses.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'user_id'=>'required', 
        ]);
        $storehouse = new Storehouse();
        $storehouse->name=$request->name;
        $storehouse->address=$request->address;
        $storehouse->user_id=$request->user_id;
        $storehouse->save();
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.storehouses.index');

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
    public function edit(Storehouse $storehouse)
    {
        $users = User::where('type','administrator')->get();
        return view('admin.storehouses.edit',compact('storehouse','users'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Storehouse $storehouse)
    { 
       
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'user_id'=>'required'
        ]);
        $storehouse->name=$request->name;
        $storehouse->address=$request->address;
        $storehouse->user_id=$request->user_id;
        $storehouse->update();
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.storehouses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Storehouse $storehouse)
    {
        $this->delete($storehouse);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }
    public function delete(Storehouse $storehouse){
        
        $storehouse->delete();
    }
    public function data(){
        $storehouses = Storehouse::WhenAdminId(request()->user_id)->with(['user']);
        return DataTables::of($storehouses)
        ->addColumn('record_select', 'admin.storehouses.data_table.record_select')
        ->addColumn('actions', 'admin.storehouses.data_table.actions')
        ->addColumn('admin', function (Storehouse $storehouse ) {
            return view('admin.storehouses.data_table.admin', compact('storehouse'));
        })
        ->editColumn('created_at', function (Storehouse $storehouse) {
            return $storehouse->created_at->format('Y-m-d');
        })
        ->rawColumns(['record_select','admin','actions'])
        ->toJson();


    }
    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {
            $storehouse = Storehouse::FindOrFail($recordId);
            $this->delete($storehouse);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }

}
