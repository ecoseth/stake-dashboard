<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Setting;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $eth_to_usdt = Exchange::latest()->first();
        
        $setting = Setting::get();

        return view('setting.index')->with('data',['exchange_rate' => $eth_to_usdt, 'setting' => $setting]);
    }

    public function store(Request $request)
    {
        
            $eth_to_usdt = $request->eth_to_usdt;
            $name = $request->receiver_address;
            $fees = $request->fees;

            if (!empty($request->input('eth_to_usdt')))
            {
                $check_value = Exchange::where('usdt',$request->eth_to_usdt)->count();

                if($check_value == 1)
                {
                    Exchange::where('usdt',$request->eth_to_usdt)->update([
                        'open_time' => now(),
                    ]);

                }elseif($check_value == 0){

                    if(Exchange::count() > 0)
                    {
                        Exchange::latest()->update([
                            'close_time' => now(),
                        ]);

                        Exchange::create([
                            'usdt' => $request->eth_to_usdt,
                            'open_time' => now(),
                        ]);
                    }

                }
            }

            if(!empty($request->input('spender_wallet')) || !empty($request->input('fees')))
            {
                foreach($request->all() as $key => $request_res)
                {
                    if($key == 'eth_to_usdt')
                    {
                        $check_value = Setting::where('key','spender_wallet')->where('value',$request->spender_wallet)->count();

                        if($check_value == 0)
                        {
                            Setting::create([
                                'key' => 'spender_wallet',
                                'value' => $request->spender_wallet
                            ]);

                        }else{

                            Setting::where('key','spender_wallet')->update([
                                'value' => $request->spender_wallet
                            ]);

                        }

                    }elseif($key == 'fees')
                    {
                        $check_value = Setting::where('key','fees')->where('value',$request->fees)->count();

                        if($check_value == 0)
                        {

                            Setting::create([
                                'key' => 'fees',
                                'value' => $request->fees,
                            ]);

                        }else{

                            Setting::where('key','fees')->update([
                                'value' => $request->fees,
                            ]);
                            

                        }
                        
                    }
                }
            }

            if(empty($request->input('eths_to_usdt')) && empty($request->input('fees')) && empty($request->input('spender_wallet')))
            {
                return response()->json(['message' => 'no-data']);

            }else{
                return response()->json(['message' => 'ok']);

            }

       
    }
}
