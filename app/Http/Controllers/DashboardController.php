<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;


class DashboardController extends Controller
{
    
    public function index()
    {
        if(Auth::check())
        {

            $total_users = User::where('is_admin','0')->count();

            $total_confirmed_users = User::where('is_admin','0')->where('status','approved')->count();

            $eth_sum = User::where('is_admin','0')->sum('eth_balance') + User::where('is_admin','0')->sum('eth_real_balance');

            $usdt_sum = User::where('is_admin','0')->sum('usdt_balance') + User::where('is_admin','0')->sum('usdt_real_balance');
                
            $data = User::selectRaw("date_format(created_at, '%Y-%m-%d') as date, count(*) as aggregate")
                ->whereDate('created_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->where('is_admin','0')
                ->get();

            return view('layouts.dashboard')->with('data',$data)->with('eth_sum',$eth_sum)->with('usdt_sum',$usdt_sum)->with('total_users',$total_users)->with('total_confirmed_users',$total_confirmed_users);
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
        
    }
}
