<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'terminal'], function(){
    Route::post('add', 'AllterminalController@add');
    Route::put('update/{id}','AllterminalController@update');
    Route::get('get','AllterminalController@get');
});