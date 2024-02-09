<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdermachineController extends Controller
{
    public function addorder(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'customer'=>'required',
            'type_id'=>'required',
            'model_id'=>'required',
            'quantity'=>'required',
            'status_id'=>'required',
        ]);
        if($validator->fails()) {
            $response =[
                'success' =>false,
                'status' => 402,
                'message' =>"Please input all information",
            ];
            return response()->json($response, 402);
        }
    }
}
