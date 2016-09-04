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

Route::auth();

// PREFIX POUR LES LANGUES

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{

    Route::get('/', ['as' => 'accueil','uses'=>'PostController@index']);
    Route::get('/destructionsession', ['as' => 'destructionsession','uses'=>'PostController@destructionsession']);
    Route::get('/logs', ['as' => 'logs', function () {
        $logs = \File::get(storage_path().'/logs/laravel.log');
        dd($logs);
    }]);
    Route::get('/phpinfo', ['as' => 'phpinfo', function () {
        phpinfo();
    }]);
    Route::get('/post/{slug}', ['as' => 'lepost','uses'=>'PostController@lePost']);
    Route::get('/posts/{tag}', ['as' => 'posts.tag','uses'=>'PostController@postsParTag']);
    Route::post('/ajout/produit', ['as' => 'produit.ajout','uses'=>'EcommerceController@ajoutProduitPanier']);
    Route::get('/recuperation/tableau/panier', ['as' => 'panierSousFormeDeTableau','uses'=>'EcommerceController@panierSousFormeDeTableau']);
    Route::get('/recuperation/total/panier', ['as' => 'panier','uses'=>'EcommerceController@recupererTotalPanier']);


    //Routes SUPER ADMIN
    Route::group(['middleware' => ['role:super_admin']], function() {
        Route::get('/super_admin', ['as' => 'super_admin','uses'=>'SuperAdminController@index']);
        Route::get('/users', ['as' => 'users','uses'=>'SuperAdminController@tousLesUsers']);
        Route::get('/user/{id}', ['as' => 'users.show','uses'=>'SuperAdminController@show']);
        Route::get('/recherche/user/{nom}', ['as' => 'user.recherche','uses'=>'SuperAdminController@rechercheUser']);
        Route::get('edit/user/{id}', ['as' => 'users.edit','uses'=>'SuperAdminController@edit']);
        Route::patch('/user/{id}',['as'=>'users.update','uses'=>'SuperAdminController@update']);
        Route::delete('delete/user/{id}',['as'=>'users.delete','uses'=>'SuperAdminController@destroy']);
        Route::get('/recherche/role/{role}', ['as' => 'recherche.role','uses'=>'SuperAdminController@recherche']);
        Route::post('/recherche/nom/{nom?}', ['as' => 'recherche.nom','uses'=>'SuperAdminController@rechercheParNom']);
        Route::get('/autocomplete', ['as' => 'autocomplete','uses'=>'SuperAdminController@autocomplete']);
        Route::get('/vat_checker/{vat?}', ['as' => 'vat','uses'=>'SuperAdminController@vatChecker']);
    });
    
    //Routes SUPER ADMIN & FORMATEU
    Route::group(['middleware' => ['role:super_admin|formateur']], function() {
        Route::get('/formateur', 'FormateurController@index');
    });
});

//Routes POUR VUEJS
Route::get('/produits/prix/{orderPrix?}', ['as' => 'produits','uses'=>'ProduitsController@index']);
Route::get('/produits/nom/{orderNom?}', ['as' => 'produits','uses'=>'ProduitsController@index']);


