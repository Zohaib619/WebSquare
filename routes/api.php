<?php

use App\Http\Controllers\Api\{CustomerController,AuthController, ProductController, UserController};
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

// User Route
Route::controller(UserController::class)->group(function(){
    Route::get('users', 'all_users');
    Route::put('user-update/{id}', 'update_user');
    Route::delete('user-delete/{id}', 'delete_user');
});

// Customer Route
Route::controller(CustomerController::class)->group(function(){
    Route::get('customers', 'all_customers');
    Route::post('customer-add', 'add_customer');
    Route::put('customer-update/{id}', 'update_customer');
    Route::delete('customer-delete/{id}', 'delete_customer');
});

// Product Route
Route::controller(ProductController::class)->group(function(){
    Route::get('products', 'all_products');
    Route::post('product-add', 'add_product');
    Route::get('product/{id}/edit', 'edit_product');
    Route::put('product-update/{id}', 'update_product');
    Route::delete('product-delete/{id}', 'delete_product');
});