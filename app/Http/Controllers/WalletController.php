<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function storeWalletAddress(Request $request)
    {
        $walletAddress = $request->input('walletAddress');

        if(Session::has('walletAddress'))
        {
            Session::forget('walletAddress');
        }

        Session::put('walletAddress', $walletAddress);

        return response()->json(['wallet' => $walletAddress]);
    }
}
