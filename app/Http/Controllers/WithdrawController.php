<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use App\Models\User;
use App\Models\Profit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Auth;

class WithdrawController extends Controller
{
    
    public function withdraws(){

        $data = Withdraw::get();

        return view('users.withdraws',compact('data'));
    }

    public function approveStatus(Request $request){
        
        Log::info($request->all());

        $withdraw_request = Withdraw::where('id',$request->withdraw_id)->first();

        $user_id = User::where('wallet',$withdraw_request->withdraw_wallet)->value('user_id');

        Withdraw::where('id',$request->withdraw_id)->update([
            'status' => 'approved',
            'updated_by' => Auth::id()
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
