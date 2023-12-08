<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class SiteController extends Controller
{
    
    public function AddSite(Request $request)
    {
        $create =[
            'site_name' =>$request->input('site_name'),
        ];
            Site::create($create);
        $response = [
            'success' => true,
            'status' => 200,
            'message' => "Add site successfully",
            'data' =>$create,
        ];
        return response()->json($response, 400);
    }
    public function UpdateSite(Request $request, $id)
    {
        $update =[
            'site_name' =>$request->input('site_name'),
        ];
        $data = Site::where('id','=',$id)->update($update);
        $response = [
            'success' => true,
            'status' => 200,
            'message' => "Updated  site successfully",
        ];
        return response()->json($response, 200);
    }
    public function DeleteSite($id)
    {
        Site::where('id',$id)->delete();
        $response = [
            'success' => true,
            'status' => 200,
            'message' => "Delete site successfully",
        ];
        return response()->json($response, 200);

    }
    public function GetallSite()
    {
        $data = Site::get();
        return $data;
    }
}
