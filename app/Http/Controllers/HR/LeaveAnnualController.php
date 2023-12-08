<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\ParentController;
use App\Models\HR\LeaveAnnual;
use App\Models\HR\Year;
use App\Services\HR\LeaveAnnualService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveAnnualController extends ParentController
{
    public function __construct(
        LeaveAnnual $leaveAnnual,
        LeaveAnnualService $leaveAnnualService,
    )
    {
        $this->model = $leaveAnnual;
        $this->service = $leaveAnnualService;
    }
    public function all(): JsonResponse
    {
        return parent::all();
    }
    public function getYear() {
        $years = Year::all();
        return response()->json($years);
    }
    public function dataTable(Request $request, $query = null): JsonResponse
    {
        return parent::dataTable($request, $query);
    }
    public function create(Request $request): JsonResponse
   {
        return parent::create($request);
   }
   public function update(Request $request, $id): JsonResponse
   {
       return parent::update($request, $id);
   }
   public function delete($id): JsonResponse
   {
       return parent::delete($id);
   }
   public function getLeaveStaff($id)
   {
        $staff = DB::table('leaves')
        ->join('leave_annuals', 'leaves.id', '=', 'leave_annuals.leave_id')
        ->join('users', 'users.id', '=', 'leave_annuals.user_id')
        ->join('years', 'years.id', '=', 'leave_annuals.year_id')
        ->where('user_id', $id)
        ->orderBy('leave_annuals.id')
        ->select('leave_annuals.id', 'leaves.leave_name', 'leave_annuals.credit_leave', 'leave_annuals.user_id', 'leave_annuals.year_id', 'years.year_number')
        ->get();

        return $staff;
   }

   public function filterLeave($id)
   {
        $leave = DB::table('leaves')
        ->join('leave_annuals', 'leaves.id', '=', 'leave_annuals.leave_id')
        ->join('users', 'users.id', '=', 'leave_annuals.user_id')
        ->orderBy('leave_annuals.id')
        ->where('users.id', $id)->get();

        return $leave;
   }
}
