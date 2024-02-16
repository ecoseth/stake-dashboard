<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    
    public function index()
    {
        if(Auth::check())
        {
            return view('layouts.dashboard')->with('loader',true);
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
        
    }
}
