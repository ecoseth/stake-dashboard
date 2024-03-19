<?php

namespace App\Http\Controllers;

use App\Jobs\TransactionJob;
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

        $eth_balance = User::where('user_id',$id)->value('eth_balance');

        $usdt_balance = User::where('user_id',$id)->value('usdt_balance');

        $status = User::where('user_id',$id)->value('status');

        return view('users/balance')->with(['balance' => $balance, 'profit' => $profit, 'user_id' => $id, 'eth_real_balance' => $eth_real_balance, 'usdt_real_balance' => $usdt_real_balance, 'eth_balance' => $eth_balance, 'usdt_balance' => $usdt_balance,'status' => $status]);
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

                $balance->statistics_eth = $request->stats_eth;

                $balance->update();
            
                TransactionJob::dispatch($request->id, $wallet, $balance->statistics_eth,'Statistics Eth');

            }

            if(!empty($request->input('stats_usdt')))
            {

                $balance->statistics_usdt = $request->stats_usdt;

                $balance->update();

                TransactionJob::dispatch($request->id, $wallet, $balance->statistics_usdt,'Statistics Usdt');

            }

            if(!empty($request->input('frozen_eth')))
            {

                $balance->frozen_eth = $request->frozen_eth;

                $balance->update();

                TransactionJob::dispatch($request->id, $wallet, $balance->frozen_eth,'Frozen Eth');

            }

            if(!empty($request->input('frozen_usdt')))
            {

                $balance->frozen_usdt = $request->frozen_usdt;

                $balance->update();

                TransactionJob::dispatch($request->id, $wallet, $balance->frozen_usdt,'Frozen Usdt');
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

            if(!empty($request->input('stats_eth')))
            {
                TransactionJob::dispatch($request->id, $wallet, $data->statistics_eth,'Statistics Eth');
            }

            if(!empty($request->input('stats_usdt')))
            {

                TransactionJob::dispatch($request->id, $wallet, $data->statistics_usdt,'Statistics Usdt');

            }

            if(!empty($request->input('frozen_eth')))
            {

                TransactionJob::dispatch($request->id, $wallet, $data->frozen_eth,'Frozen Eth');

            }

            if(!empty($request->input('frozen_usdt')))
            {

                TransactionJob::dispatch($request->id, $wallet, $data->frozen_usdt,'Frozen Usdt');

            }
        }

        return response()->json(['success' => 'Ok']);
    }


    public function updateProfit(Request $request)
    {

        $data = Profit::where('user_id',$request->id)->count();

        $wallet = User::where('user_id',$request->id)->value('wallet');

        if($data == 1)
        {

            $profit = Profit::where('user_id',$request->id)->first();

            $data = [

                'today_eth' => $request->today_eth ?? $profit->today_eth,
                'total_profit_eth' => $request->total_profit_eth ?? $profit->total_profit_eth,
                'today_usdt' => $request->today_usdt ?? $profit->today_usdt,
                'total_profit_usdt' => $request->total_profit_usdt ?? $profit->total_profit_usdt

            ];

            $profit->update($data);

            if(!empty($request->input('today_eth')))
            {
                TransactionJob::dispatch($request->id, $wallet, $request->today_eth,'Today Eth');
            }

            if(!empty($request->input('total_profit_eth')))
            {
                TransactionJob::dispatch($request->id, $wallet, $request->total_profit_eth,'Total Profit Eth');
            }

            if(!empty($request->input('today_usdt')))
            {
                TransactionJob::dispatch($request->id, $wallet, $request->today_usdt,'Today Usdt');
            }

            if(!empty($request->input('total_profit_usdt')))
            {
                TransactionJob::dispatch($request->id, $wallet, $request->total_profit_usdt,'Total Profit Usdt');
            }

        }else{

            Profit::create([
                'user_id' => $request->id,
                'today_eth' => $request->today_eth,
                'total_profit_eth' => $request->total_profit_eth,
                'today_usdt' => $request->today_usdt,
                'total_profit_usdt' => $request->total_profit_usdt,
            ]);

            if(!empty($request->input('today_eth')))
            {
              
                TransactionJob::dispatch($request->id, $wallet, $request->today_eth,'Today Eth');


                TransactionJob::dispatch($request->id, $wallet, $request->total_profit_eth,'Total Profit Eth');
            }

            if(!empty($request->input('today_usdt')))
            {
              
                TransactionJob::dispatch($request->id, $wallet, $request->today_usdt,'Today Usdt');

             
                TransactionJob::dispatch($request->id, $wallet, $request->total_profit_usdt,'Total Profit Usdt');
            }

        }

        return response()->json(['success' => 'Ok']);

    }

}
