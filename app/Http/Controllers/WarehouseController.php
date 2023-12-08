<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Services\WarehouseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends ParentController
{
    public function __construct(
        Warehouse $warehouse,
        WarehouseService $warehouseService
    ) {
        $this->model = $warehouse;
        $this->service = $warehouseService;
    }

    public function AddWarehouse(Request $request)
    {
        $create = [
            'customer_id' => $request->input('customer_id'),
            'warehouse_name' => $request->input('warehouse_name'),
        ];
        $data = DB::table('warehouses')
            ->where('customer_id', '=', $request['customer_id'])
            ->where('warehouse_name', '=', $request['warehouse_name'])
            ->count();
        if ($data > 0) {
            $response = [
                'success' => false,
                'status' => 400,
                'message' => "This warehouse is exits",
            ];
            return response()->json($response, 400);
        }
        $data1 = Warehouse::create($create);
        $response = [
            'success' => true,
            'status' => 200,
            'message' => "Add new warehouse successfully",
            'data' => $data1,
        ];
        return response()->json($response, 200);
    }
    public function  UpdateWarehouse(Request $request, $id)
    {
        $update = [
            'customer_id' => $request->input('customer_id'),
            'warehouse_name' => $request->input('warehouse_name'),
        ];
        $data = DB::table('warehouses')
                ->where('customer_id', '=', $request['customer_id'])
                ->where('warehouse_name', '=', $request['warehouse_name'])
                ->count();
        if ($data > 0) {
            $response = [
                'success' => false,
                'status' => 400,
                'message' => "This warehouse is exits",
            ];
            return response()->json($response, 400);
        }
        Warehouse::where('id','=', $id)->update($update);
        $response = [
            'success' => true,
            'status' => 200,
            'message' => "Updated  warehouse successfully",
        ];
        return response()->json($response, 200);
    }
    public function GetallWarehouse()
    {
        $data = Warehouse::get();

        return $data;
    }
    
}
