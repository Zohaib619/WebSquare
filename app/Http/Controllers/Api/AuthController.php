<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // User Register
    function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "username" => "required|unique:users,username",
            "password" => "required",
            // "avator" => "required"
        ]);

        if ($validator->fails()) {
            return api_response(false, $validator->errors(), null);
        }

        // creating user
        $user = new User();
        $user->avator = "https://eu.ui-avatars.com/api/?name=$req->name&size=250";
        $user->name = $req->name;
        $user->username = $req->username;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();
        $result['user'] = $user;
        $result['token'] = $user->createToken('my-app')->plainTextToken;
        return api_response(true, 'User Registered Successfully', $result);
    }

    // login user
    function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "email" => "required|email",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            return api_response(false, $validator->errors(), null);
        }

        // Authorizing user
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
            $user = Auth::user();
            $result['user'] = $user;
            $result['token'] = $user->createToken('my-app')->plainTextToken;
            return api_response(true, 'User Login Successfully', $result);
        } else {
            return api_response(false, 'Invalid Credentials', null);
        }
    }
}
