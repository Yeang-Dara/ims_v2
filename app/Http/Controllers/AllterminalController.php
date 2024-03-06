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
            return response()->json($response);
        }
        Allterminal::create($input);
        $response = [
            'success' => true,
            'status' => 200,
            'message' => "Add new terminal successfully",
            'data' => $input
        ];
        return response()->json($response);
    }
    public function update(Request $request,$id)
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
        $data = DB::table('allterminals')->where('atm_id','=',$request['atm_id'])
                                        ->where('id','!=',$id)->count();
        
        if($data >0){
            $response =[
                'success' =>false,
                'status' => 403,
                'message' =>"This atm ID alredy exit",
            ];
            return response()->json($response,403);
        }
        Allterminal::where('id','=',$id)->update($input);
        $response = [
            'success' => true,
            'status' => 200,
            'message' => "Updated terminal successfully",
            'data' => $input
        ];
        return response()->json($response);
    }
    public function get()
    {
        $data =  DB::table('allterminals')
                ->join('banklocations','banklocations.id','=','allterminals.banklocation_id')
                ->join('sites','sites.id','=','banklocations.site_name_id')
                ->join('customers','customers.id','=','banklocations.bank_name_id')
                ->join('terminalmodels','terminalmodels.id','=','allterminals.model_id')
                ->join('terminaltypes','terminaltypes.id','=','allterminals.type_id')
                ->join('categories','categories.id','=','allterminals.category_id')
                ->join('terminalstatuses','terminalstatuses.id','=','allterminals.status_id')
                ->select('customers.customer_name',
                            'banklocations.siteID',
                            'banklocations.address',
                            'sites.site_name',
                            'terminalmodels.terminal_model',
                            'terminaltypes.terminal_type',
                            'categories.category_name',
                            'terminalstatuses.status',
                            'allterminals.*',)
                ->orderBy('allterminals.id')->get();
                return response()->json($data);
    }
    public function getID($id)
    {
       
        $data =  DB::table('allterminals')->where('allterminals.id','=',$id)->get();
        return response()->json($data);
    }
    public function getViewdetail($id)
    {
        $data =  DB::table('allterminals')
        ->join('banklocations','banklocations.id','=','allterminals.banklocation_id')
        ->join('customers','customers.id','=','banklocations.bank_name_id')
        ->join('sites','sites.id','=','banklocations.site_name_id')
        ->join('terminalmodels','terminalmodels.id','=','allterminals.model_id')
        ->join('terminaltypes','terminaltypes.id','=','terminalmodels.terminaltype_id')
        ->join('categories','categories.id','=','allterminals.category_id')
        ->join('terminalstatuses','terminalstatuses.id','=','allterminals.status_id')
        ->select('customers.customer_name',
                    'banklocations.siteID',
                    'banklocations.address',
                    'sites.site_name',
                    'terminalmodels.terminal_model',
                    'terminaltypes.terminal_type',
                    'categories.category_name',
                    'terminalstatuses.status',
                    'allterminals.*',)       
        ->where('allterminals.id','=',$id)->get();
        return response()->json($data);
    }

    public function getFilter(Request $request)
    {
       if($request->model_id && $request->type_id && $request->bank_id){
        $data =  DB::table('allterminals')
        ->join('banklocations','banklocations.id','=','allterminals.banklocation_id')
        ->join('customers','customers.id','=','banklocations.bank_name_id')
        ->join('sites','sites.id','=','banklocations.site_name_id')
        ->join('terminalmodels','terminalmodels.id','=','allterminals.model_id')
        ->join('terminaltypes','terminaltypes.id','=','terminalmodels.terminaltype_id')
        ->join('categories','categories.id','=','allterminals.category_id')
        ->join('terminalstatuses','terminalstatuses.id','=','allterminals.status_id')
        ->select('customers.customer_name',
                    'banklocations.siteID',
                    'banklocations.address',
                    'banklocations.bank_name_id',
                    'sites.site_name',
                    'terminalmodels.terminal_model',
                    'terminaltypes.terminal_type',
                    'categories.category_name',
                    'terminalstatuses.status',
                    'allterminals.*',)       
        ->where('allterminals.model_id','=',$request->model_id)
        ->where('banklocations.bank_name_id','=',$request->bank_id)
        ->where('allterminals.type_id','=',$request->type_id)
        ->orderBy('allterminals.id')->get();
        return response()->json($data);
       }
       else if($request->model_id && $request->type_id ){
        $data =  DB::table('allterminals')
        ->join('banklocations','banklocations.id','=','allterminals.banklocation_id')
        ->join('customers','customers.id','=','banklocations.bank_name_id')
        ->join('sites','sites.id','=','banklocations.site_name_id')
        ->join('terminalmodels','terminalmodels.id','=','allterminals.model_id')
        ->join('terminaltypes','terminaltypes.id','=','terminalmodels.terminaltype_id')
        ->join('categories','categories.id','=','allterminals.category_id')
        ->join('terminalstatuses','terminalstatuses.id','=','allterminals.status_id')
        ->select('customers.customer_name',
                    'banklocations.siteID',
                    'banklocations.address',
                    'banklocations.bank_name_id',
                    'sites.site_name',
                    'terminalmodels.terminal_model',
                    'terminaltypes.terminal_type',
                    'categories.category_name',
                    'terminalstatuses.status',
                    'allterminals.*',)       
        ->where('allterminals.model_id','=',$request->model_id)
        ->where('allterminals.type_id','=',$request->type_id)
        ->orderBy('allterminals.id')->get();
        return response()->json($data);
       }
       else if($request->model_id && $request->bank_id ){
        $data =  DB::table('allterminals')
        ->join('banklocations','banklocations.id','=','allterminals.banklocation_id')
        ->join('customers','customers.id','=','banklocations.bank_name_id')
        ->join('sites','sites.id','=','banklocations.site_name_id')
        ->join('terminalmodels','terminalmodels.id','=','allterminals.model_id')
        ->join('terminaltypes','terminaltypes.id','=','terminalmodels.terminaltype_id')
        ->join('categories','categories.id','=','allterminals.category_id')
        ->join('terminalstatuses','terminalstatuses.id','=','allterminals.status_id')
        ->select('customers.customer_name',
                    'banklocations.siteID',
                    'banklocations.address',
                    'banklocations.bank_name_id',
                    'sites.site_name',
                    'terminalmodels.terminal_model',
                    'terminaltypes.terminal_type',
                    'categories.category_name',
                    'terminalstatuses.status',
                    'allterminals.*',)       
        ->where('allterminals.model_id','=',$request->model_id)
        ->where('banklocations.bank_name_id','=',$request->bank_id)
        ->orderBy('allterminals.id')->get();
        return response()->json($data);
       }
       else if($request->type_id && $request->bank_id)
       {
        $data =  DB::table('allterminals')
        ->join('banklocations','banklocations.id','=','allterminals.banklocation_id')
        ->join('customers','customers.id','=','banklocations.bank_name_id')
        ->join('sites','sites.id','=','banklocations.site_name_id')
        ->join('terminalmodels','terminalmodels.id','=','allterminals.model_id')
        ->join('terminaltypes','terminaltypes.id','=','terminalmodels.terminaltype_id')
        ->join('categories','categories.id','=','allterminals.category_id')
        ->join('terminalstatuses','terminalstatuses.id','=','allterminals.status_id')
        ->select('customers.customer_name',
                    'banklocations.siteID',
                    'banklocations.address',
                    'banklocations.bank_name_id',
                    'sites.site_name',
                    'terminalmodels.terminal_model',
                    'terminaltypes.terminal_type',
                    'categories.category_name',
                    'terminalstatuses.status',
                    'allterminals.*',)       
        ->where('banklocations.bank_name_id','=',$request->bank_id)
        ->where('allterminals.type_id','=',$request->type_id)
        ->orderBy('allterminals.id')->get();
        return response()->json($data);
       }
       else if($request->type_id)
       {
        $data =  DB::table('allterminals')
        ->join('banklocations','banklocations.id','=','allterminals.banklocation_id')
        ->join('customers','customers.id','=','banklocations.bank_name_id')
        ->join('sites','sites.id','=','banklocations.site_name_id')
        ->join('terminalmodels','terminalmodels.id','=','allterminals.model_id')
        ->join('terminaltypes','terminaltypes.id','=','terminalmodels.terminaltype_id')
        ->join('categories','categories.id','=','allterminals.category_id')
        ->join('terminalstatuses','terminalstatuses.id','=','allterminals.status_id')
        ->select('customers.customer_name',
                    'banklocations.siteID',
                    'banklocations.address',
                    'banklocations.bank_name_id',
                    'sites.site_name',
                    'terminalmodels.terminal_model',
                    'terminaltypes.terminal_type',
                    'categories.category_name',
                    'terminalstatuses.status',
                    'allterminals.*',)       
        ->where('allterminals.type_id','=',$request->type_id)
        ->orderBy('allterminals.id')->get();
        return response()->json($data);
       }
       else if($request->model_id)
       {
        $data =  DB::table('allterminals')
        ->join('banklocations','banklocations.id','=','allterminals.banklocation_id')
        ->join('customers','customers.id','=','banklocations.bank_name_id')
        ->join('sites','sites.id','=','banklocations.site_name_id')
        ->join('terminalmodels','terminalmodels.id','=','allterminals.model_id')
        ->join('terminaltypes','terminaltypes.id','=','terminalmodels.terminaltype_id')
        ->join('categories','categories.id','=','allterminals.category_id')
        ->join('terminalstatuses','terminalstatuses.id','=','allterminals.status_id')
        ->select('customers.customer_name',
                    'banklocations.siteID',
                    'banklocations.address',
                    'banklocations.bank_name_id',
                    'sites.site_name',
                    'terminalmodels.terminal_model',
                    'terminaltypes.terminal_type',
                    'categories.category_name',
                    'terminalstatuses.status',
                    'allterminals.*',)       
        ->where('allterminals.model_id','=',$request->model_id)
        ->orderBy('allterminals.id')->get();
        return response()->json($data);
       }
       else if($request->bank_id)
       {
        $data =  DB::table('allterminals')
        ->join('banklocations','banklocations.id','=','allterminals.banklocation_id')
        ->join('customers','customers.id','=','banklocations.bank_name_id')
        ->join('sites','sites.id','=','banklocations.site_name_id')
        ->join('terminalmodels','terminalmodels.id','=','allterminals.model_id')
        ->join('terminaltypes','terminaltypes.id','=','terminalmodels.terminaltype_id')
        ->join('categories','categories.id','=','allterminals.category_id')
        ->join('terminalstatuses','terminalstatuses.id','=','allterminals.status_id')
        ->select('customers.customer_name',
                    'banklocations.siteID',
                    'banklocations.address',
                    'banklocations.bank_name_id',
                    'sites.site_name',
                    'terminalmodels.terminal_model',
                    'terminaltypes.terminal_type',
                    'categories.category_name',
                    'terminalstatuses.status',
                    'allterminals.*',)       
        ->where('banklocations.bank_name_id','=',$request->bank_id)
        ->orderBy('allterminals.id')->get();
        return response()->json($data);
       }
       $data =  DB::table('allterminals')
       ->join('banklocations','banklocations.id','=','allterminals.banklocation_id')
       ->join('sites','sites.id','=','banklocations.site_name_id')
       ->join('customers','customers.id','=','banklocations.bank_name_id')
       ->join('terminalmodels','terminalmodels.id','=','allterminals.model_id')
       ->join('terminaltypes','terminaltypes.id','=','terminalmodels.terminaltype_id')
       ->join('categories','categories.id','=','allterminals.category_id')
       ->join('terminalstatuses','terminalstatuses.id','=','allterminals.status_id')
       ->select('customers.customer_name',
                   'banklocations.siteID',
                   'banklocations.address',
                   'sites.site_name',
                   'terminalmodels.terminal_model',
                   'terminaltypes.terminal_type',
                   'categories.category_name',
                   'terminalstatuses.status',
                   'allterminals.*',)
       ->orderBy('allterminals.id')->get();
       return response()->json($data);
    }
    
}
