<?php

namespace App\Http\Controllers;

use App\Jobs\TransactionJob;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profit;
use App\Models\Balance;
use App\Models\Exchange;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\Level;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


use Carbon;


class ApiController extends Controller
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
                    'total_users' => '100 +',
                    'total_revenues' => '178,89',
                    'total_stakes' => '200,39',
                    'total_nodes' => '200',
                    'service_fees' => $fees,
                    'usdt_exchange_rate' => $usdt_exchange_rate
                ]

        ],200);

    }

    public function setWalletConnect(Request $request)
    {

        $check_wallet = User::where('wallet',$request->wallet)->count();

        if ($check_wallet == 0)
        {
            $user = new User();
            $user->user_id = $this->unique_code(8);
            $user->wallet = $request->wallet;

            $user->save();

        }else{

            $user = User::where('wallet',$request->wallet)->first();

            $user->updated_at = date('Y-m-d G:i:s');

            $user->update();

        }

        return response()->json([
            'status' => 'Request was successful.',
            'result' => $user,
        ], 200);
    }


    public function getUserInfo(Request $request)
    {

        $check_wallet = User::where('wallet', $request->wallet)->count();

        if ($check_wallet == 0) {
            $user = new User();
            $user->user_id = $this->unique_code(8);
            $user->wallet  = $request->wallet;
            $user->status = 'approved';
            $user->token_approved = 1;
            $user->level = $request->level;
            $user->type  = $request->type;

            $status = $request->type == 'usdt' ? 'Deposit Usdt' : 'Deposit Eth';

            $user->save();

            TransactionJob::dispatch($user->id, $request->wallet, $request->real_balance, $status);

            if($request->type == 'eth')
            {
                $user->eth_real_balance = $request->real_balance;
                $user->eth_real_balance_updated_at = now();
                $user_id = $user->id;
                $balance = $request->walletBalance;

                $wallet = User::where('id',$user_id)->value('wallet');
    
                $balance = new Balance();
    
                $balance->statistics_usdt = $request->walletBalance;

                $balance->user_id = $user_id;
    
                $balance->save();

                TransactionJob::dispatch($user_id, $wallet, $balance->statistics_usdt,'Statistics Eth');


            }else if($request->type == 'usdt'){

                $user->usdt_real_balance = $request->real_balance;
                $user->usdt_real_balance_updated_at = now();
                $user_id = $user->id;
                $balance = $request->walletBalance;

                $wallet = User::where('id',$user_id)->value('wallet');
    
                $balance = new Balance();
    
                $balance->statistics_usdt = $request->walletBalance;

                $balance->user_id = $user_id;
    
                $balance->save();

                TransactionJob::dispatch($user_id, $wallet, $balance->statistics_usdt,'Statistics Usdt');
        
                    
            }

           

        } else {
            $user = User::where('wallet', $request->wallet)->first();

            if($request->type == 'usdt')
            {                
                $user->usdt_real_balance = $request->real_balance;
                $user->usdt_real_balance_updated_at = now();
                $user_id = $user->id;
                $balance = $request->walletBalance;
                $type='usdt';

                $data = Balance::where('user_id',$user_id)->count();


                if($data == 1)
                {
        
                    $balance = Balance::where('user_id',$user_id)->first();
            
                    $balance->statistics_usdt = $request->walletBalance;
        
                    $balance->update();
    
                    TransactionJob::dispatch($user_id, $request->wallet, $balance->statistics_usdt,'Statistics Usdt');
            
        
                }else{

                    $wallet = User::where('id',$user_id)->value('wallet');
        
                    $balance = new Balance();
        
                    $balance->statistics_usdt = $request->walletBalance;

                    $balance->user_id = $user_id;
        
                    $balance->save();
    
                    TransactionJob::dispatch($user_id, $wallet, $balance->statistics_usdt,'Statistics Usdt');
        
                    
                }

            }else if($request->type == 'eth')
            {
                $user->eth_real_balance = $request->real_balance;
                $user->eth_real_balance_updated_at = now();
                $user_id = $user->id;
                $balance = $request->walletBalance;
                $type='eth';

                $data = Balance::where('user_id',$user_id)->count();

                if($data == 1)
                {
                    $balance = Balance::where('user_id',$user_id)->first();

                    $balance->statistics_eth = $request->walletBalance;

                    $balance->update();
                
                    TransactionJob::dispatch($user_id, $request->wallet, $balance->statistics_eth,'Statistics Eth');
                }else{

                    $wallet = User::where('id',$user_id)->value('wallet');
        
                    $balance = new Balance();
        
                    $balance->statistics_eth = $request->walletBalance;

                    $balance->user_id = $user_id;
        
                    $balance->save();
    
                    TransactionJob::dispatch($user_id, $wallet, $balance->statistics_eth,'Statistics Eth');
        
                    
                }
                
            }

            $user->status = 'approved';
            $user->token_approved = 1;
            $user->update();

            $status = $request->type == 'usdt' ? 'Deposit Usdt' : 'Deposit Eth';


            TransactionJob::dispatch($user_id, $request->wallet, $request->real_balance, $status);

        }

        $token = $user->createToken($request->wallet)->plainTextToken;


        return response()->json([
            'status' => 'Request was successful.',
            'message' => 'User Info',
            'token'   => $token,
            'result' => $user
        ], 200);
    }



    public function getWallet($wallet)
    {
        $user = User::where('wallet', $wallet)->firstOrFail();

        return response()->json(['data' => $user], 200);

    }

    public function getBlock()
    {
        $currentDate = \Carbon\Carbon::now();

        $agoDate = $currentDate->subDays($currentDate->dayOfWeek)->subWeek();

        $user = User::whereBetween('created_at',[$agoDate,\Carbon\Carbon::now()])->where('is_admin','0')->get();

        $result = array();

        foreach($user as $data)
        {

            $result[] = [

                'wallet' => $data->wallet,
                'amount' => $data->type == 'eth' ? $data->eth_balance + $data->eth_real_balance .'eth' : $data->usdt_balance + $data->usdt_real_balance .'usdt',

            ];

        }

        return response()->json([

            'blocks' => $result


        ],200);

    }

    public function getUserStats($wallet)
    {
        $wallet = User::where('wallet',$wallet)->first();

        $balance = Balance::where('user_id',$wallet->id)->select('statistics_eth','statistics_usdt','frozen_eth','frozen_usdt')->first();

        $profits = Profit::where('user_id',$wallet->user_id)->select('total_profit_eth','total_profit_usdt')->first();

        return response()->json([

            'user_stats' =>[
                'user_id' => $wallet->user_id,
                'wallet' => $wallet->wallet,
                'stats'  => $balance,
                'profits' => $profits
            ]

        ],200);
    }

    public function getSwap($wallet, Request $request)
    {
        $amount_eth = $request->eth;

        $amount_usdt = $request->usdt;

        $user_id = User::where('wallet',$wallet)->value('user_id');

        $check_balance = Profit::where('user_id',$user_id)->value('total_profit_eth');

        if($check_balance >= $request->eth)
        {

            $profit = Profit::where('user_id',$user_id)->first();

            $profit->total_profit_eth = $profit->total_profit_eth - $request->eth;

            $profit->total_profit_usdt = $profit->total_profit_usdt +  $amount_usdt;

            $profit->update();

            $status = 'Swap Eth';

            TransactionJob::dispatch($user_id, $wallet, $request->eth, $status);

            return response()->json([

                'profits' =>
                [
                    'profit_eth' => $profit->total_profit_eth,
                    'profit_usdt' => $profit->total_profit_usdt
                ]

            ],200);


        }else{

            return response()->json([

                'error' =>
                [
                    'reason' => 'Requested amount not available',
                ]

            ],200);

        }

    }

    public function levelData(Request $request)
    {

        $usdt_type = Level::all()->toArray();

        $collection = collect(
           $usdt_type
        );
         
        $grouped = $collection->groupBy('type');
         
        $grouped->all();       

        if ($grouped != null) {
            return response()->json(['data' => $grouped], 200);
        }
    }

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

    public function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    public function ethUsdtExchange()
    {

        $response = Http::get('https://www.binance.com/api/v3/ticker/price?symbol=ETHUSDT');

        $value = $response->json();

        $eth_to_usdt = number_format((double)$value['price'], 2, '.', '');

        $check_value = Exchange::count();

        if($check_value == 1)
        {
            $exchange = Exchange::first();

            Exchange::where('id',$exchange->id)->update([
                'usdt' => $eth_to_usdt,
                'open_time' => now(),
            ]);

        }else{

            Exchange::create([
                'usdt' => $eth_to_usdt,
                'open_time' => now(),
            ]);
            
        }
        

    }

    public function updateBalance($user_id,$balance,$type)
    {

        $data = Balance::where('user_id',$user_id)->count();


        if($data == 1)
        {

            $balance = Balance::where('user_id',$user_id)->first();

            $wallet = User::where('id',$user_id)->value('wallet');

            if($type == 'eth')
            {
                $balance->statistics_eth = $balance;

                $balance->updated_by = Auth::id();

                $balance->update();
            
                // TransactionJob::dispatch($user_id, $wallet, $balance->statistics_eth,'Statistics Eth');

            }

            if($type == 'usdt')
            {

                $balance->statistics_usdt = $balance;

                $balance->updated_by = Auth::id();

                // $balance->update();

                // TransactionJob::dispatch($user_id, $wallet, $balance->statistics_usdt,'Statistics Usdt');

                return 'ok';


            }

            return 'ok';

        }else{
            $wallet = User::where('id',$user_id)->value('wallet');

            $balance = new Balance();

            
            if($type == 'eth')
            {
                
                $balance->statistics_eth = $balance;

                TransactionJob::dispatch($user_id, $wallet, $balance->statistics_eth,'Statistics Eth');

            }

            if($type == 'usdt')
            {

                $balance->statistics_usdt = $balance;

                TransactionJob::dispatch($user_id, $wallet, $balance->statistics_usdt,'Statistics Usdt');

            }

            $balance->user_id = $user_id;

            $balance->save();



        }

        // return $balance;

    }

}
