<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Setting;

use Illuminate\Http\Request;

use Auth;

class SettingController extends Controller
{
    public function index()
    {
        $eth_to_usdt = Exchange::latest()->first();
        
        $setting = Setting::select('key','value','action')->get();

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

                }else{

                    Exchange::create([
                        'usdt' => $request->eth_to_usdt,
                        'open_time' => now(),
                    ]);
                    
                }
            }

          
            foreach($request->all() as $key => $request_res)
            {
                
                if($key == 'spender_wallet' && !empty($request->input('spender_wallet')))
                {
                  
                    Setting::where('key','spender_wallet')->update([
                        'value' => $request->spender_wallet,
                        'action' => Auth::id()
                    ]);

                }

                if($key == 'fees' && !empty($request->input('fees')))
                {

                    Setting::where('key','fees')->update([
                        'value' => $request->fees,
                        'action' => Auth::id()

                    ]);
                    
                }

                if($key == 'nodes' && !empty($request->input('nodes')))
                {
                   
                    Setting::where('key','nodes')->update([
                        'value' => $request->nodes,
                        'action' => Auth::id()

                    ]);
                    
                }
            }
            

            if(empty($request->input('eth_to_usdt')) && empty($request->input('fees')) && empty($request->input('spender_wallet')) && empty($request->input('nodes')))
            {
                return response()->json(['message' => 'no-data']);

            }else{

                return response()->json(['message' => 'ok']);

            }
    }

    
}
