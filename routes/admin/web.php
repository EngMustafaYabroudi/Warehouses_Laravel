<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\profileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StorehouseController;
use App\Http\Controllers\Admin\Profile\PasswordController;

use App\Http\Controllers\Admin\Storehouse_mangament\ProductsController;
use App\Http\Controllers\Admin\Storehouse_mangament\EmployeesController;

Route::middleware([
    // 'localeSessionRedirect',
    // 'localizationRedirect',
    // 'localeViewPath',
    'auth',
    'role:user|administrator|superadministrator',
])->group(function () {

        Route::name('admin.')->prefix('admin')->group(function () {

            //home
            Route::get('/home/top_statistics', [DashboardController::class,'topStatistics'])->name('home.top_statistics');
            Route::get('/home/movies_chart', [DashboardController::class,'moviesChart'])->name('home.movies_chart');
            Route::get('/home', [DashboardController::class,'index'])->name('home');

            //role routes
            Route::get('/roles/data',[RoleController::class,'data'] )->name('roles.data');
            Route::delete('/roles/bulk_delete', [RoleController::class,'bulkDelete'])->name('roles.bulk_delete');
            Route::resource('roles', RoleController::class);
            //
            Route::get('/admins/data', [AdminController::class,'data'])->name('admins.data');
            Route::delete('/admins/bulk_delete',[AdminController::class,'bulkDelete'] )->name('admins.bulk_delete');
            Route::resource('admins', AdminController::class);


            // user routes
            Route::get('/users/data', [UserController::class,'data'])->name('users.data');
            Route::delete('/users/bulk_delete', [UserController::class,'bulkDelete'])->name('users.bulk_delete');
            Route::resource('users', UserController::class);

            //category routes
            Route::get('/category/data',[CategoryController::class,'data'] )->name('category.data');
            Route::delete('/category/bulk_delete', [CategoryController::class,'bulkDelete'])->name('category.bulk_delete');
            Route::resource('category', CategoryController::class);
            //product routes
            Route::get('/product/data',[ProductController::class,'data'] )->name('product.data');
            Route::delete('/product/bulk_delete', [ProductController::class,'bulkDelete'])->name('product.bulk_delete');
            Route::resource('product', ProductController::class);

            // Employee routes
            Route::get('/employees/data', [EmployeeController::class,'data'])->name('employees.data');
            Route::delete('/employees/bulk_delete', [EmployeeController::class,'bulkDelete'])->name('employees.bulk_delete');
            Route::resource('employees', EmployeeController::class);

            
             // Storehouse routes
             Route::get('/storehouses/data', [StorehouseController::class,'data'])->name('storehouses.data');
             Route::delete('/storehouses/bulk_delete', [StorehouseController::class,'bulkDelete'])->name('storehouses.bulk_delete');
             Route::resource('storehouses', StorehouseController::class);

             

             //storehouses management
             
             Route::name('Storehouse_mangament.')->group(function () {
                //products routes
                Route::get('/products/data', [ ProductsController::class,'data'])->name('products.data');
                Route::resource('products', ProductsController::class);
                Route::resource('employees',EmployeesController::class);
            });


           
            //Setting
            Route::get('/settings/general', [SettingController::class,'general'])->name('settings.general');
            Route::resource('settings', SettingController::class)->only(['store']);
           
            //profile routes
            Route::get('/profile/edit', [profileController::class,'edit'])->name('profile.edit');
            Route::put('/profile/update',[profileController::class,'update'])->name('profile.update');

            Route::name('profile.')->namespace('Profile')->group(function () {

                //password routes
                Route::get('/password/edit', [PasswordController::class,'edit'])->name('password.edit');
                Route::put('/password/update', [PasswordController::class,'update'])->name('password.update');

            });

            });

        });


        Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => '\App\Http\Controllers\LanguagesController@switchLang']);

        Route::get('pp', [ ProductsController::class,'data'])->name('products.data');