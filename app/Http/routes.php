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
    Route::delete('delete/user/{id}',['as'=>'users.delete','uses'=>'SuperAdminController@destroy']);
    Route::get('/recherche/role/{role}', ['as' => 'recherche.role','uses'=>'SuperAdminController@recherche']);
    Route::post('/recherche/nom/{nom?}', ['as' => 'recherche.nom','uses'=>'SuperAdminController@rechercheParNom']);

    Route::get('/autocomplete', ['as' => 'autocomplete','uses'=>'SuperAdminController@autocomplete']);
    Route::get('/vat_checker/{vat?}', ['as' => 'vat','uses'=>'SuperAdminController@vatChecker']);

 

});

Route::group(['middleware' => ['role:super_admin|formateur']], function() {
    Route::get('/formateur', 'FormateurController@index');
});