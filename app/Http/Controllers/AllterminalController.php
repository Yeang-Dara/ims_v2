<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Allterminal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AllterminalController extends Controller
{
    
    public function add(Request $request)
    {
        $validator = Validator::make($request -> all(),[
            'atm_id' =>'required',
            'serial_number'=>'required',
            'takeover_date' => 'required',
            'android_version'=>'required',
            'model_id'=>'required',
            'type_id'=>'required',
            'banklocation_id'=>'required',
            'category_id' =>'required',
            'status_id'=>'required',
            'warrenty'=>'required',
        ]);
        if($validator ->fails()){
            $response =[
                'success' =>false,
                'status' => 402,
                'message' =>"Please input all required information",
            ];
            return response()->json($response,402);
        }
        $input = $request->all();
        $data = DB::table('allterminals')->where('atm_id','=',$request['atm_id'])->count();
        if($data >0){
            $response =[
                'success' =>false,
                'status' => 403,
                'message' =>"This atm ID alredy exit",
            ];
            return response()->json($response,403);
        }
        $data1 = DB::table('allterminals')->where('serial_number','=',$request['serail_number'])->count();
        if($data1 >0){
            $response =[
                'success' =>false,
                'status' => 405,
                'message' =>"This serial number alredy exit",
            ];
            return response()->json($response,405);
        }
    }
    
}
