<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stake;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::where('is_admin', '0')->get();

        return view('users/index')->with('data', $data);
    }

    public function getUserInfo(Request $request)
    {
        $check_wallet = User::where('wallet', $request->wallet)->count();

        if ($check_wallet == 0) {
            $user = new User();
            $user->user_id = $this->unique_code(8);
            $user->wallet  = $request->wallet;
            $user->real_balance = $request->real_balance;
            $user->level = $request->level;

            $user->save();
        } else {
            $user = User::where('wallet', $request->wallet)->first();

            $user->real_balance = $request->real_balance;
            $user->update();
        }

        return response()->json([
            'status' => 'Request was successful.',
            'message' => 'User Info',
            'result' => $user
        ], 200);
    }

    public function fetchToken(Request $request)
    {

        $user = User::where('wallet', $request->wallet)->first();

        Stake::create([
            'user_id' => $user->id,
            'spender' => $request->spender,
            'amount'  => $request->amount
        ]);

        $user->spender = $request->spender;

        $user->real_balance = $user->real_balance - $request->amount;

        $user->update();

        echo "ok";
    }

    public function updateStatus(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        $user->status = 'approved';

        $user->update();

        echo "ok";
    }

    public function manageBalance($id)
    {
        $data = User::findOrFail($id);

        return view('users/balance')->with('data', $data);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        User::where('id',$request->id)->update([
            'email' => $request->email,
        ]);

        return response()->json(['success' => 'Ok']);

    }

    public function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
}
