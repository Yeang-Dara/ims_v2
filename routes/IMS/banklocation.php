<?php 

use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'banklocation'], function(){
    Route::post('addbanklocation','BanklocationController@AddBankLocation');
    Route::put('updatebanklocation/{id}','BanklocationController@UpdateBankLocation');
});
