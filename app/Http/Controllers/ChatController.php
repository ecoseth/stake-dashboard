<?php

namespace App\Http\Controllers;

use App\Models\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ChatController extends Controller
{
    public function index(Request $request)
    {
        $data = Customer::first();

        return view('customer/chat')->with('data', $data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'config' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $data_count = Customer::count();

        if($data_count == 1)
        {
            Customer::query()->update([ 

                'chat_config' => $request->config,
                'user_id' => Auth::id(),
            ]);

        }else{

            Customer::create([
                'chat_config' => $request->config,
                'user_id' => Auth::id(),
            ]);

        }

        return response()->json([

            'message' => 'ok',
            'updated_by' => Auth::user()->name

        ]);

    }
}
