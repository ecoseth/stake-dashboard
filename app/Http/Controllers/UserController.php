<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::all();

        return view('users/index')->with('data',$data);

    }

    public function getUserInfo(Request $request)
    {
        
    }
}
