<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
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
	  if ($validator->fails()) {
            $message = $validator->errors()->first();
            $errors=$validator->errors()->first();
            $code='200';
            $response = array(
                'success' => false,
                'message' => $message,
                "errors" => $errors
            );
            return new JsonResponse($response, $code);
    }
        $register = User::create($request->all());
        return $register;
    }
}
