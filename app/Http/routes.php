<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();


Route::group(['middleware' => ['role:super_admin']], function() {
    Route::get('/super_admin', ['as' => 'super_admin','uses'=>'SuperAdminController@index']);
    Route::get('/user/{id}', ['as' => 'users.show','uses'=>'SuperAdminController@show']);
    Route::get('edit/user/{id}', ['as' => 'users.edit','uses'=>'SuperAdminController@edit']);
    Route::patch('/user/{id}',['as'=>'users.update','uses'=>'SuperAdminController@update']);
    
});

Route::group(['middleware' => ['role:super_admin|formateur']], function() {
    Route::get('/formateur', 'FormateurController@index');
});