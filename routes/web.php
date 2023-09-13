<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function (){
//    Route::get('dashboard',[DashboardController::class,'index']);
// });

// Route::middleware([
//     'auth',
//     ])->group(function () {
    
//             Route::name('admin.')->prefix('admin')->group(
//                 function () {

//                     // Home
//                     Route::get('/home',[DashboardController::class,'index'])->name('home');
//                     // Role
//                     Route::get('/roles/data', 'RoleController@data')->name('roles.data');
//                     Route::delete('/roles/bulk_delete', 'RoleController@bulkDelete')->name('roles.bulk_delete');
//                     Route::resource('roles',RoleController::class);

//                 });});
     
        
    
// Languages
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => '\App\Http\Controllers\LanguagesController@switchLang']);