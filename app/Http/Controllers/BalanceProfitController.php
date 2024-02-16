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
        $balance = Balance::where('user_id',$id)->first();

        $profit = Profit::where('user_id',$id)->first();

        $eth_real_balance = User::where('user_id',$id)->value('eth_real_balance');

        $usdt_real_balance = User::where('user_id',$id)->value('usdt_real_balance');

        return view('users/balance')->with(['balance' => $balance, 'profit' => $profit, 'user_id' => $id, 'eth_real_balance' => $eth_real_balance, 'usdt_real_balance' => $usdt_real_balance]);
    }

    public function updateBalance(Request $request)
    {

        $data = Balance::where('user_id',$request->id)->count();

        if($data == 1)
        {

            $balance = Balance::where('user_id',$request->id)->first();

            $wallet = User::where('user_id',$request->id)->value('wallet');

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

}
