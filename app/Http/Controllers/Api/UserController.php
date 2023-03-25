<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // get all Users
    function all_users(){
        $users = User::all();
        if(!$users->isEmpty()){
            return api_response(true,"Users Found", $users);
        }else{
            return api_response(true,"Users not found", []);
        }
    }

    // update user
    function update_user(Request $req, $id){
        $validator = Validator::make($req->all(), [
            "name" => "required",
            "email" => "required",
            "username" => "required",
        ]);

        if($validator->failed()){
            return api_response(false, $validator->errors()->first(), null);
        }
        $user = User::find($id);
        $user->name = $req->name;
        $user->email = $req->email;
        $user->username = $req->username;
        $user->save();
        return api_response(true, "User Updated Successfully", $user);
    }

    // User Delete
    function delete_user($id){
        $user = User::find($id);
        if($user){
            $user->delete();
            return api_response(false, "User Deleted Successfully", null);
        }else{
            return api_response(false, "User not found", null);

        }
    }
}
