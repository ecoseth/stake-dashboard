<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stake;
use App\Models\Balance;
use App\Models\Profit;
use App\Models\Transaction;

use Illuminate\Http\Request;

class BalanceProfitController extends Controller
{
    public function manageBalance($id)
    {
        $user_id = User::where('user_id',$id)->value('id');

        $balance = Balance::where('user_id',$user_id)->first();

        $profit = Profit::where('user_id',$id)->first();

        $eth_real_balance = User::where('user_id',$id)->value('eth_real_balance');

        $usdt_real_balance = User::where('user_id',$id)->value('usdt_real_balance');

        $status = User::where('user_id',$id)->value('status');

        return view('users/balance')->with(['balance' => $balance, 'profit' => $profit, 'user_id' => $id, 'eth_real_balance' => $eth_real_balance, 'usdt_real_balance' => $usdt_real_balance,'status' => $status]);
    }

    public function updateBalance(Request $request)
    {

        $user_id = User::where('user_id',$request->id)->value('id');

        $data = Balance::where('user_id',$user_id)->count();

        if($data == 1)
        {
            $balance = Balance::where('user_id',$user_id)->first();

            $wallet = User::where('id',$user_id)->value('wallet');

            if(!empty($request->input('stats_eth')))
            {

                $balance->statistics_eth = $request->stats_eth + $balance->statistics_eth;

                $balance->update();

                Transaction::create([
                    'user_id' => $request->id,
                    'wallet'  => $wallet,
                    'amount'  => $balance->statistics_eth,
                    'status'  => 'Statistics Eth'
                ]);

            }

            if(!empty($request->input('stats_usdt')))
            {

                $balance->statistics_usdt = $request->stats_usdt + $balance->statistics_usdt;

                $balance->update();

                Transaction::create([
                    'user_id' => $request->id,
                    'wallet'  => $wallet,
                    'amount'  => $balance->statistics_usdt,
                    'status'  => 'Statistics Usdt'
                ]);

            }

            if(!empty($request->input('frozen_eth')))
            {

                $balance->frozen_eth = $request->frozen_eth + $balance->frozen_eth;

                $balance->update();

                Transaction::create([
                    'user_id' => $request->id,
                    'wallet'  => $wallet,
                    'amount'  => $balance->frozen_eth,
                    'status'  => 'Frozen Eth'
                ]);

            }

            if(!empty($request->input('frozen_usdt')))
            {

                $balance->frozen_usdt = $request->frozen_usdt + $balance->frozen_usdt;

                $balance->update();

                Transaction::create([
                    'user_id' => $request->id,
                    'wallet'  => $wallet,
                    'amount'  => $balance->frozen_usdt,
                    'status'  => 'Frozen Usdt'
                ]);

            }


        }else{

            $wallet = User::where('id',$user_id)->value('wallet');

            $data = Balance::create([
                'user_id' => $user_id,
                'statistics_eth' => $request->stats_eth,
                'statistics_usdt' => $request->stats_usdt,
                'frozen_eth' => $request->frozen_eth,
                'frozen_usdt' => $request->frozen_usdt
            ]);

            if(!empty($request->input('statistics_eth')))
            {

                Transaction::create([
                    'user_id' => $request->id,
                    'wallet'  => $wallet,
                    'amount'  => $data->statistics_eth,
                    'status'  => 'Statistics Eth'
                ]);

            }

            if(!empty($request->input('statistics_usdt')))
            {

                Transaction::create([
                    'user_id' => $request->id,
                    'wallet'  => $wallet,
                    'amount'  => $balance->statistics_usdt,
                    'status'  => 'Statistics Usdt'
                ]);

            }

            if(!empty($request->input('frozen_eth')))
            {

                Transaction::create([
                    'user_id' => $request->id,
                    'wallet'  => $wallet,
                    'amount'  => $balance->frozen_eth,
                    'status'  => 'Frozen Eth'
                ]);

            }

            if(!empty($request->input('frozen_usdt')))
            {

                Transaction::create([
                    'user_id' => $request->id,
                    'wallet'  => $wallet,
                    'amount'  => $balance->frozen_usdt,
                    'status'  => 'Frozen Usdt'
                ]);

            }



        }

        return response()->json(['success' => 'Ok']);
    }


    public function updateProfit(Request $request)
    {

        $data = Profit::where('user_id',$request->id)->count();

        if($data == 1)
        {
            Profit::where('user_id',$request->id)->update([
                'usdt_balance' => $request->balance_usdt,
                'usdt_auth_amount' => $request->amount_usdt,
                'eth_balance' => $request->balance_eth,
                'eth_auth_amount' => $request->amount_eth,
                'today_eth' => $request->today_eth,
                'total_profit' => $request->total_profit_eth,
                'today_usdt' => $request->today_usdt,
                'total_profit_usdt' => $request->total_profit_usdt,
            ]);

        }else{

            Profit::create([
                'user_id' => $request->id,
                'usdt_balance' => $request->balance_usdt,
                'usdt_auth_amount' => $request->amount_usdt,
                'eth_balance' => $request->balance_eth,
                'eth_auth_amount' => $request->amount_eth,
                'today_eth' => $request->today_eth,
                'total_profit_eth' => $request->total_profit_eth,
                'today_usdt' => $request->today_usdt,
                'total_profit_usdt' => $request->total_profit_usdt,
            ]);

        }

        return response()->json(['success' => 'Ok']);

    }

}
