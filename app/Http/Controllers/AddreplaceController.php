<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addreplace;
use App\Models\Sparepart;
use App\Services\AddreplaceService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AddreplaceController extends ParentController
{
    public function __construct(
        Addreplace $addreplace,
        AddreplaceService $addreplaceService,
    )
    {
        $this->model = $addreplace;
        $this->service= $addreplaceService;
    }
    public function create(Request $request): JsonResponse
    {
        $data = DB::table('spareparts')->where('id','=',$request['sparepart_id'])->get();
        // $data1['quantity_remain'] = $data['quantity_remain']-$request['quantity'];
        // Sparepart::where('id','=',$request['sparepart_id'])->update($data1['quantity_remain']);

        // return parent::create($request);
        return $data;
       
    }
    public function update(Request $request, $id): JsonResponse
    {

        return parent::update($request, $id);
    }
    public function delete($id): JsonResponse
    {
        return parent::delete($id);
    }
}
