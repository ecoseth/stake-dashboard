<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;


class SortingController extends Controller
{
  
    public function updateOrder(Request $request)
    {
        $sorting = Content::all();
        
        foreach ($sorting as $s1)
        {
            foreach ($request->order as $sort){
                if ($s1['uuid'] == $sort['id']) {
                    Content::where('uuid',$s1['uuid'])->update([

                        'sort' => $sort['position']
                    ]);
                }
            }

            
        }


        return response()->json([
            'success' => true,
                'message' => 'success',
            ]);    
}

}
