<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ProfileRequest;

class profileController extends Controller
{
   
    public function edit()
    {
        return view('admin.profile.edit');

    }// end of getChangeData
    public function update(ProfileRequest $request)
    {
        $requestData = $request->validated();

        if ($request->hasFile('image_upload')) {
            
            if (file_exists(public_path('Admin/user_images/'.auth()->user()->image))){
              //  $filedeleted = unlink(public_path('Admin/user_images/'.auth()->user()->image));
             } 
            $image =$request->file('image_upload');
            $file_name = uniqid().$image->getClientOriginalName();
            auth()->user()->image = $file_name;
            Storage::putFileAs('user_images', $image,$file_name); 
        } 
        $user = auth()->user();
        $user->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.home');

        
    }

}
