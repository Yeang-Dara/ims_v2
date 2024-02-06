<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'clientLog'], function () {
    Route::post('convert-file','LogFile@convertFile');
    Route::post('upload-file', 'LogFile@uploadfile');
    Route::get('getData', 'LogFile@getAll');
    Route::post('list-qr', 'LogFile@QRScanLog_date');
    Route::post('qrServer', 'LogFile@QRScanLog_time');

    Route::post('search-device', 'LogFile@SearchDevice_time');
    Route::post('list-device', 'LogFile@SearchDevice');
    Route::post('device-time', 'LogFile@DeviceTime');
});
