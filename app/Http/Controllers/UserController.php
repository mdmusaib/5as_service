<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $allUsers = User::all(['id','name','role']);
        return $allUsers;
    }
}
