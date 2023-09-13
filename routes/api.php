<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication Routes
Route::prefix('auth')->as('auth.')->group(function () {
    Route::post('login',[AuthenticationController::class,'login'])->name('login');
    Route::post('register',[AuthenticationController::class,'register'])->name('register');
    Route::get('logout',[AuthenticationController::class,'logout'])->name('logout');
    Route::post('login_with_token',[AuthenticationController::class,'loginWithToken'])->middleware('auth:sanctum')->name('login_with_token');

});

// Categories Routes
Route::prefix('category')->group(function(){
    Route::get('/',[CategoryController::class,'index']);
    Route::post('/store',[CategoryController::class,'store']);
    Route::post('/update',[CategoryController::class,'update']);
    Route::post('/delete',[CategoryController::class,'destroy']);
    Route::post('/archive',[CategoryController::class,'archive']);
    Route::post('archive/restore',[CategoryController::class,'move_From_archive']);
    Route::get('archive/show_archive',[CategoryController::class,'show_archive']);
    Route::post('show_products',[CategoryController::class,'get_products']);
});

// Product Routes
Route::prefix('product')->group(function(){
    Route::get('/',[ProductController::class,'index']);
    Route::post('/store',[ProductController::class,'store']);
    Route::post('/update',[ProductController::class,'update']);
    Route::post('/delete',[ProductController::class,'destroy']);
    Route::post('/archive',[ProductController::class,'archive']);
    Route::post('archive/restore',[ProductController::class,'move_From_archive']);
    Route::get('archive/show_archive',[ProductController::class,'show_archive']);
    Route::post('/show_category',[ProductController::class,'get_category']);
  
});