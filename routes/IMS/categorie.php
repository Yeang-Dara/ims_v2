<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'categorie'],function(){
    Route::post('add','CategoryController@AddCategory');
});