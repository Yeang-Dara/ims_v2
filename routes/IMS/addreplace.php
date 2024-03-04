<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'replace'],function(){
    Route::post('add','AddreplaceController@create');
    Route::put('update/{id}','AddreplaceController@update');

});