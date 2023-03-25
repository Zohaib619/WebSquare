<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // fetch product 
    function all_products(){
        $products = Product::all();
        if(!$products->isEmpty()){
            return api_response(true, "Products found", $products);
        }else{
            return api_response(false, "Products not found", null);
        }
    }

    // Add Product
    function add_product(Request $req){
        $validator = Validator::make($req->all(), [
            "name" => "required",
            "description" => "required",
            "retail_price" => "required",
            "wholesale_price" => "required",
        ]);
        if($validator->fails()){
            return api_response(false, $validator->errors()->first(), null);
        }

        $product = new Product();
        $product->name = $req->name;
        $product->description = $req->description;
        $product->retail_price = $req->retail_price;
        $product->wholesale_price = $req->wholesale_price;
        $result = $product->save();
        if($result){
            return api_response(true, "Product Added Successfully", $product);
        }else{
            return api_response(false, "Product not added ", null);
        }
    }

    // Get Editing product data
    function edit_product($id){
        $product = Product::find($id);
        if($product){
            return api_response(true, "Product Found", $product);
        }else{
            return api_response(false, "Product not Found", null);
        }
    }
    // Update Product
    function update_product(Request $req, $id){
        $validator = Validator::make($req->all(), [
            "name" => "required",
            "description" => "required",
            "retail_price" => "required",
            "wholesale_price" => "required",
        ]);
        if($validator->fails()){
            return api_response(false, $validator->errors()->first(), null);
        }

        $product = Product::find($id);
        $product->name = $req->name;
        $product->description = $req->description;
        $product->retail_price = $req->retail_price;
        $product->wholesale_price = $req->wholesale_price;
        $result = $product->save();
        if($result){
            return api_response(true, "Product Updated Successfully", $product);
        }else{
            return api_response(false, "Product not updated ", null);
        }
    }

    // Delete Product
    function delete_product($id){
        $product = Product::find($id);
        if($product){
            $product->delete();
            return api_response(true, 'Product Deleted Successfully', null);
        }else{
            return api_response(false, 'Product not found', null);
        }
    }
}
