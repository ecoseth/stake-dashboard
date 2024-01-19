<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Level;
use Illuminate\Validation\Rule;

use Auth;


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
            'name' => ['required', Rule::unique('levels')->ignore($this->level)],
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
    
    
}
