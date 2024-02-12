<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Services\SparepartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SparepartController extends ParentController
{
    public function __construct(
        Sparepart $sparepart,
        SparepartService $sparepartService,
    )
    {
        $this->model= $sparepart;
        $this->service = $sparepartService;
    }
   public function test1()
   {
    return ("Testing");
   }

   public function create(Request  $request):JsonResponse
   {

    $validator = Validator::make($request->all(),[
            'model_id' => 'required',
            'sparepart_name' =>'required',
            'quantity' =>'required',
    ]);
    if($validator->fails()) {
        $response =[
            'success' =>false,
            'status' => 402,
            'message' =>"Please input all information",
        ];
        return response()->json($response, 402);
    }


    $request['quantity_remain'] = $request['quantity']- $request['quantity_used'];
    return parent::create($request);
   }
   public function updateData(Request $request, $id)
   {

    $data = Sparepart::find($id);

    if($request['quantity']==null)
    {
        $request['quantity_remain'] = $data['quantity']- $request['quantity_used'];
        return parent::update($request, $id);
    }
        $request['quantity_remain'] = $request['quantity']- $request['quantity_used'];
        return parent::update($request, $id);

   }
   public function delete($id):JsonResponse
   {
    return parent::delete($id);
   }
   public function getData()
   {
     $data = DB::table('spareparts')->orderBy('id')->get();
     return $data;
   }
}
