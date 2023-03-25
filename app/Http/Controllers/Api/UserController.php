<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
}
