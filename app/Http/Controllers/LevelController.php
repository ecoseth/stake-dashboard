<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    public function index(Request $request)
    {
        $data = Level::all();

        return view('levels/index')->with('data', $data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:levels',
            'min_amount' => 'required',
            'max_amount' => 'required',
            'percentage' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        Level::create([
            'name' => $request->name,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'percentage' => $request->percentage,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => 'Ok']);

    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',

            'min_amount' => 'required',
            'max_amount' => 'required',
            'percentage' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        Level::where('id',$request->id)->update([
            'name' => $request->name,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'percentage' => $request->percentage,
        ]);

        return response()->json(['success' => 'Ok']);

    }

    public function destroy(Level $level,Request $request)
    {
        Level::where('id',$request->id)->delete();
        return response()->json(['success' => 'Ok']);
    }

    // level api
    // public function levelData(Request $request) {
    //     $wei_amount = $request->weiAmount;

    //     $levels = Level::all();

    //     $levelData = null;

    //     foreach ($levels as $level) {
    //         $minAmount = floatval($level->min_amount);
    //         $maxAmount = floatval($level->max_amount);

    //         if ($wei_amount >= $minAmount && $wei_amount <= $maxAmount) {
    //             $levelData = [
    //                 'name' => $level->name,
    //                 'min_amount' => $level->min_amount,
    //                 'max_amount' => $level->max_amount,
    //                 'percentage' => $level->percentage,
    //             ];
    //             break;
    //         }
    //     }

    //     if ($levelData != null) {
    //         return response()->json(['data' => $levelData], 200);
    //     } else {
    //         return response()->json(['error' => 'Wei Amount data is not within any level range'], 404);
    //     }
    // }

    public function levelData(Request $request) {
        $wei_amount = $request->weiAmount;

        $levels = Level::all();

        $levelData = [];

        foreach ($levels as $level) {
            $minAmount = floatval($level->min_amount);
            $maxAmount = floatval($level->max_amount);

            $levelData[] = [
                'name' => $level->name,
                'min_amount' => $level->min_amount,
                'max_amount' => $level->max_amount,
                'percentage' => $level->percentage,
            ];

        }

        if ($levelData != null) {
            return response()->json(['data' => $levelData], 200);
        } else {
            return response()->json(['error' => 'Wei Amount data is not within any level range'], 404);
        }
    }

}

