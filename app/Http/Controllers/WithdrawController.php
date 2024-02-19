<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use App\Models\User;
use App\Models\Profit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WithdrawController extends Controller
{
    public function createWithdraw(Request $request){

        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'withdraw_wallet' => 'required',
            'network' => 'required',
            'amount' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $check_user = User::where('user_id',$request->user_id)->count();

        if($check_user == 1)
        {
            $data = [
                'user_id' => $request->user_id,
                'network' => $request->network,
                'withdraw_wallet' => $request->withdraw_wallet,
                'amount' => $request->amount,
            ];

            Withdraw::create($data);

            return response()->json(['message' => 'Withdraw data added successfully']);

        }else{

            return response()->json(['error' => 'User id not found']);

        }

    }

    public function withdraws(){

        $data = Withdraw::get();

        return view('users.withdraws',compact('data'));
    }

    public function approveStatus(Request $request){
        Log::info($request->all());

        $withdraw_request = Withdraw::where('id',$request->withdraw_id)->first();

        $user_id = User::where('wallet',$withdraw_request->withraw_wallet)->value('user_id');

        Withdraw::where('id',$request->withdraw_id)->update([
            'status' => 'approved'
        ]);

        Profit::where('user_id',$user_id)->decrement('total_profit_usdt',$withdraw_request->amount);

        echo "ok";
    }

    public function rejectStatus(Request $request){
        Log::info($request->all());

        Withdraw::where('id',$request->withdraw_id)->update([
            'status' => 'rejected'
        ]);

        echo "ok";
    }
}
