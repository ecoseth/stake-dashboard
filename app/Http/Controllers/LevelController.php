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
            'type' => 'required',
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

        Level::create([
            'type' => $request->type,
            'name' => $request->name,
            'min_amount' => str_replace(' ','',$request->min_amount),
            'max_amount' => str_replace(' ','',$request->max_amount),
            'percentage' => str_replace(' ','',$request->percentage),
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
            'min_amount' => str_replace(' ','',$request->min_amount),
            'max_amount' => str_replace(' ','',$request->max_amount),
            'percentage' => str_replace(' ','',$request->percentage),
        ]);

        return response()->json(['success' => 'Ok']);

    }

    public function destroy(Level $level,Request $request)
    {
        Level::where('id',$request->id)->delete();
        return response()->json(['success' => 'Ok']);
    }

    
}

