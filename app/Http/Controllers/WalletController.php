<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function storeWalletAddress(Request $request)
    {
        $walletAddress = $request->input('walletAddress');

        session(['walletAddress' => $walletAddress]);

        return response()->json(['message' => 'Wallet address stored successfully']);
    }
}
