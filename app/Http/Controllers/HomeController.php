<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profit;
use App\Models\Balance;
use App\Models\Exchange;
use App\Models\Setting;
use Carbon;


class HomeController extends Controller
{
    public function homeAsset()
    {
        $count_users = User::where('status','approved')->count();

        $usdt_exchange_rate = Exchange::all()->last()->usdt;

        $eth_sum_stakes = User::where('is_admin','0')->sum('eth_balance') + User::where('is_admin','0')->sum('eth_real_balance');

        $usdt_sum_stakes = User::where('is_admin','0')->sum('usdt_balance') + User::where('is_admin','0')->sum('usdt_real_balance');

        $profit_eth_sum = Profit::sum('total_profit_eth');

        $profit_usdt_sum = Profit::sum('total_profit_usdt');

        $eth_to_usdt_stakes = $eth_sum_stakes * $usdt_exchange_rate;

        $eth_to_usdt_profits = $profit_eth_sum * $usdt_exchange_rate;

        $total_revenues = $eth_to_usdt_profits + $profit_usdt_sum;

        $total_stakes = $eth_to_usdt_stakes + $usdt_sum_stakes;

        $total_nodes = Setting::where('key','nodes')->value('value');

        $fees = Setting::where('key','fees')->value('value');


        return response()->json([

        
            'setting' =>
                [
                    'total_users' => $count_users,
                    'total_revenues' => $total_revenues,
                    'total_stakes' => $total_stakes,
                    'total_nodes' => $total_nodes,
                    'service_fees' => $fees,
                    'usdt_exchange_rate' => $usdt_exchange_rate
                ]

        ],200);

    }

    public function getBlock()
    {
        $currentDate = \Carbon\Carbon::now();

        $agoDate = $currentDate->subDays($currentDate->dayOfWeek)->subWeek();

        $user = User::whereBetween('created_at',[$agoDate,\Carbon\Carbon::now()])->where('is_admin','0')->get();

        $result = [];


        foreach($user as $data)
        {

            $result = [

                'wallet' => $data->wallet,
                'amount' => $data->type == 'eth' ? $data->eth_balance + $data->eth_real_balance .'eth' : $data->usdt_balance + $data->usdt_real_balance .'usdt',

            ];

        }

        return response()->json([

            'blocks' => 
                    [
                        $result
                    ]

        ],200);
        
    }

    public function getUserStats($wallet)
    {
        $wallet = User::where('wallet',$wallet)->first();

        $balance = Balance::where('user_id',$wallet->id)->select('statistics_eth','statistics_usdt','frozen_eth','frozen_usdt')->get();

        $profits = Profit::where('user_id',$wallet->user_id)->select('total_profit_eth','total_profit_usdt')->get();

        return response()->json([

            'user-stats' =>[
                'user_id' => $wallet->user_id,
                'wallet' => $wallet->wallet,
                'stats'  => $balance,
                'profits' => $profits
            ]

        ],200);
    }
}
