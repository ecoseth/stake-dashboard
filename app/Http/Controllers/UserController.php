<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stake;
use App\Models\Balance;
use App\Models\Profit;
use App\Models\Transaction;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

            Transaction::create([

                'user_id' => $user->id,
                'wallet' => $request->wallet,
                'amount' => $request->real_balance,
                'status' => 'deposit'

            ]);

        } else {
            $user = User::where('wallet', $request->wallet)->first();

            $user->real_balance = $request->real_balance + $user->real_balance;
            $user->update();

            Transaction::create([

                'user_id' => $user->id,
                'wallet' => $request->wallet,
                'amount' => $request->real_balance,
                'status' => 'deposit'

            ]);
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

    public function transaction($id)
    {
        $user = Transaction::where('user_id', $id)->first();

        return $user;

        return view('users/transaction')->with('data',$user);
    }

    public function manageBalance($id)
    {
        $balance = Balance::where('user_id',$id)->first();

        $profit = Profit::where('user_id',$id)->first();

        $real_balance = User::where('user_id',$id)->value('real_balance');
        
        return view('users/balance')->with(['balance' => $balance, 'profit' => $profit, 'user_id' => $id, 'real_balance' => $real_balance]);
    }

    public function updateBalance(Request $request)
    {

        $data = Balance::where('user_id',$request->id)->count();

        if($data == 1)
        {
            Balance::where('user_id',$request->id)->update([
                'statistics_eth' => $request->stats_eth,
                'statistics_usdt' => $request->stats_usdt,
                'frozen_eth' => $request->frozen_eth,
                'frozen_usdt' => $request->frozen_usdt
            ]);

        }else{

            Balance::create([
                'user_id' => $request->id,
                'statistics_eth' => $request->stats_eth,
                'statistics_usdt' => $request->stats_usdt,
                'frozen_eth' => $request->frozen_eth,
                'frozen_usdt' => $request->frozen_usdt
            ]);

        }

        return response()->json(['success' => 'Ok']);
    }


    public function updateProfit(Request $request)
    {

        $data = Profit::where('user_id',$request->id)->count();

        if($data == 1)
        {
            Profit::where('user_id',$request->id)->update([
                'balance' => $request->balance_usdt,
                'auth_amount' => $request->amount_usdt,
                'today_eth' => $request->today_eth,
                'total_profit' => $request->total_profit
            ]);

        }else{

            Profit::create([
                'user_id' => $request->id,
                'balance' => $request->balance_usdt,
                'auth_amount' => $request->amount_usdt,
                'today_eth' => $request->today_eth,
                'total_profit' => $request->total_profit
            ]);

        }

        return response()->json(['success' => 'Ok']);

    }


    public function editProfile($id)
    {
        $user = User::findOrFail($id);

        return view('profile.index')->with('user', $user);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json(['success' => 'Ok']);
    }

    public function editPassword($id)
    {
        $user = User::findOrFail($id);

        return view('profile.password')->with('user', $user);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        User::where('id', $request->id)->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => 'Ok']);
    }

    public function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
}
