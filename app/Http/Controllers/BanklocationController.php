<?php

namespace App\Http\Controllers;

use App\Models\Banklocation;
use App\Services\BanklocationService;
use Illuminate\Http\Request;

class BanklocationController extends ParentController
{
    public function __construct(
        Banklocation $banklocation,
        BanklocationService $banklocationService,
    )
    { 
        $this->model = $banklocation;
        $this->service = $banklocationService;
    }
   
    public function AddBankLocation(Request $request)
    {
        $create = [
            'bank_name_id'=>$request->input('bank_name_id'),
            'site_name_id' => $request->input('site_name_id'),
            'siteID' => $request->input('siteID'),
            'address' => $request->input('address'),
        ];
        Banklocation::create($create);
        $response = [
            'success' => true,
            'status' => 200,
            'message' => "Create Bank location Successfully",
            'data' => $create
        ];
        return response()->json($response, 200);
    }
    public function UpdateBankLocation(Request $request,$id)
    {
        return parent::update($request,$id);
    }
}
