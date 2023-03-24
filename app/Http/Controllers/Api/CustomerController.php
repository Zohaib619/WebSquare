<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    // fetch all customer
    function all_customers(){
        $customers = Customer::all();
        if(!$customers->isEmpty()){
            return api_response(true, "Customer Data found", $customers);
        }else{
            return api_response(true, "Customer Data not found", null);
        }
    }
    // Add customer
    function add_customer(Request $req){
        $validator = Validator::make($req->all(), [
            "name" => "required|string",
            "email" => "required|email|unique:customers,email",
            "phone" => "required",
        ]);

        if ($validator->fails()) {
            return api_response(false, $validator->errors()->first(), null);
        }

        $customer = new Customer();
        $customer->name = $req->name;
        $customer->email = $req->email;
        $customer->phone = $req->phone;
        $customer->save();
        return api_response(true, "Customer Added Successfully", $customer);

    }
}