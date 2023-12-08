<?php

use App\Http\Controllers\TerminalController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UsingController;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HR\AttendanceController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tickets', function () {
    $users = Ticket::all();
    return response()->json($users);
});

Route::post('/import', [TicketController::class, 'import']);
Route::post('ticket/import', [TicketController::class, 'processCsv']);
Route::post('/terminal/import', [TerminalController::class, 'import']);

Route::get('/terminals', function () {
    $users = Terminal::all();
    $count = $users->count();
    $atm = DB::table('terminals')->where('atm_type', '=', 'ATM ')->count();
    $crm = DB::table('terminals')->where('atm_type', '=', 'CRM')->count();
    $dc = DB::table('terminals')->where('atm_type', '=', 'DC365')->count();

    return response()->json([
        'terminal' => $count,
        'atm' => $atm,
        'crm' => $crm,
        'dc' => $dc,
        'data' => $users
    ]);
});

Route::get('/pieChart', function() {
    $amk = DB::table('terminals')->where('bank', '=', 'AMK')->count();
    $wing = DB::table('terminals')->where('bank', '=', 'Wing')->count();
    $aba = DB::table('terminals')->where('bank', '=', 'ABA')->count();

    return response()->json([
        'amk' => $amk,
        'wing' => $wing,
        'aba' => $aba
    ]);
});

Route::get('using/all', [UsingController::class, 'getAll']);

Route::group(['prefix' => 'IMS'], function () {
    require __DIR__ . '/IMS/order.php';
    require __DIR__ . '/IMS/user.php';
    require __DIR__ . '/IMS/using.php';
    require __DIR__ . '/IMS/stock.php';
    require __DIR__ . '/IMS/mainpart.php';
    require __DIR__ . '/IMS/maintenace.php';
    require __DIR__ . '/IMS/spareparts.php';
});

Route::group(['prefix' => 'HR'], function () {
    require __DIR__ . '/HR/staff.php';
    require __DIR__ . '/HR/department.php';
    require __DIR__ . '/HR/leave.php';
    require __DIR__ . '/HR/attendance.php';
    require __DIR__ . '/HR/leaveAnnual.php';
    require __DIR__ . '/HR/role.php';
});

// Authentication
Route::controller(AuthController::class)->group(function() {
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'change_password']);
});
