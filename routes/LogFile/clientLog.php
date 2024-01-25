<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'clientLog'], function () {
    // Route::post('create', 'AttendanceController@create');
    Route::post('process-log', 'LogFile@create');
    Route::post('convert-file','LogFile@convertFile');
    Route::post('upload-file', 'LogFile@Uploadfile');
    Route::get('getData', 'LogFile@getAll');
    Route::post('list-qr', 'LogFile@QRScanLog_date');
    Route::post('qrServer', 'LogFile@QRScanLog_time');
});
