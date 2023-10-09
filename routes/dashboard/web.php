<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\Client\OrderController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
 
 



 
  
 
 
  Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware'=>'auth'], function()
{
	Route::prefix('dashboard')->name('dashboard.')->group(function(){

    Route::get('index',[DashboardController::class,'index'])->name('index') ;

    //users routes

    Route::resource('users',UserController::class)->except('show') ;

    //category routes

    Route::resource('categories',CategoryController::class)->except('show') ;

    //products routes

    Route::resource('products',ProductController::class)->except('show') ;


    //client routes
    Route::resource('clients',ClientController::class)->except('show') ;

    Route::resource('clients.orders',OrderController::class)->except('show') ;


  }) ;

  // User Routes 


	 
});
