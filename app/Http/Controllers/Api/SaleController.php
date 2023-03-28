<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    // All Sale
    function all_sales(){
        $sales = Sale::all();
        $all_sales = [];
        foreach($sales as $sale){
            $user = User::where('id', $sale->user_id)->first(['name']);
            $product = Product::where('id', $sale->product_id)->first();
            array_push($all_sales, [
                'id' => $sale->id,
                'reference' => $sale->reference,
                'customer_name' => $user->name,
                'product_name' => $product->name,
                'product_retail_price' => $product->retail_price,
                'product_qty' => $sale->quantity,
                'total' => $sale->total
            ]);
        }
        $grand_total = Sale::sum("total");
        return api_response(true, 'Sale found', ["sales" => $all_sales, "grand_total" => $grand_total]);
    }
    // Add Sale
    function add_sale(Request $request){
        $validate = Validator::make($request->all(), [
            "product_qty" => "required|integer"
        ]);
        if($validate->fails()){
            return api_response(false, $validate->errors()->first(), null);
        }

        $product = Product::find($request->product_id);
        if($product){
            $sale = new Sale();
            $sale->user_id = auth()->user()->id;
            $sale->reference = sprintf("%04d", rand(0,9999));
            $sale->product_id = $product->id;
            $sale->quantity = $request->product_qty; 
            $sale->total = $request->product_qty * $product->retail_price;
            $sale->save();
            return api_response(true, 'Sale added', $sale);
        }else{
            return api_response(false, 'No Product Found', null);
        }

    }

    // update sale
    function update_sale(Request $request,$sale_id){
        if($request->product_qty){
            $sale = Sale::join("products", "sales.product_id", "products.id")
            ->select("sales.id", "products.retail_price")
            ->find( $sale_id);
            $sale->quantity = $request->product_qty;
            $sale->total = $request->product_qty * $sale->retail_price;
            $sale->save();
            return api_response(true, 'Sale Updated', $sale);
        }else{
            return api_response(false, 'Product Qty is required', null);
        }
    }

    // Delete sale
    function delete_sale($sale_id){
        $sale = Sale::find($sale_id);
        if($sale){
            $sale->delete();
            return api_response(true, 'Sale Deleted', null);
        }else{
            return api_response(false, 'Sale not Deleted', null);
        }
    }
}
