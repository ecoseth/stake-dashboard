<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
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

        $data = [
            'user_id' => $request->user_id,
            'network' => $request->network,
            'withdraw_wallet' => $request->withdraw_wallet,
            'amount' => $request->amount,
        ];

        Withdraw::create($data);

        return response()->json(['message' => 'Withdraw data added successfully']);

    }
}
