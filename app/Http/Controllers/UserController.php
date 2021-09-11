<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $allUsers = User::all(['id','name','role']);
        return $allUsers;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'phone'=>'required',
            'role'=>'required',
            'password'=>'required',
            'name'=>'required'
        ]);
        $register = User::create($request->all());
        return $register;
    }
}
