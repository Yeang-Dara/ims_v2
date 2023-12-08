<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TicketController;
use App\Models\Terminal;
use App\Models\Ticket;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TicketsImport;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/{vue_capture?}', function() {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');

// Route::get('/tickets', [TicketController::class, 'getAll']);

// Route::get('/tickets', function () {
//     $users = Ticket::all();
//     return response()->json($users);
// });

// // Route::post('/import', [App\Http\Controllers\TicketController::class, 'import'])->name('import');
// Route::post('/api/import-csv', [TicketController::class, 'import']);

// Route::get('excel-csv-file', [ExcelCSVController::class, 'index']);
// Route::post('import-excel-csv-file', [ExcelCSVController::class, 'importExcelCSV']);
// Route::get('export-excel-csv-file/{slug}', [ExcelCSVController::class, 'exportExcelCSV']);


// // Terminal
// Route::get('/terminals', function () {
//     $users = Terminal::all();
//     return response()->json($users);
// });

// Route::post('import', function () {
//     $fileName = time().'_'.request()->file->getClientOriginalName();
//     request()->file('file')->storeAs('reports', $fileName, 'public');

//     Excel::import(new TicketsImport, request()->file('file'));
//     return response()->json("success");
//     // return redirect()->back()->with('success','Data Imported Successfully');
// });
