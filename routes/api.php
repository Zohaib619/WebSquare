<?php

use App\Http\Controllers\Api\{CustomerController,AuthController, ProductController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// Auth Route
Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
    Route::post('register', 'register');
});

// Customer Route
Route::controller(CustomerController::class)->group(function(){
    Route::get('customers', 'all_customers');
    Route::post('add-customer', 'add_customer');
});

// Product Route
Route::controller(ProductController::class)->group(function(){
    Route::get('products', 'all_products');
    Route::post('product-add', 'add_product');

});