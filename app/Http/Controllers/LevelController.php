<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;


class LevelController extends Controller
{
    public function index(Request $request)
    {
        $data = Level::all();

        return view('levels/index')->with('data', $data);
    }
    
    
}
