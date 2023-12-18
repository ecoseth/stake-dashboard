<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\HttpResponses;

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
        $user = new User();
        $user->user_id = $this->unique_code(8);
        $user->wallet  = $request->wallet;
        $user->real_balance = $request->real_balance;
        $user->level = $request->level;

        $user->save();

        return response()->json([
            'status' => 'Request was successful.',
            'message' => 'User Info',
            'result' => $user
        ], 200);
  
    }

    public function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

}
