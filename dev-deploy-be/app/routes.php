<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It"s a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::model('user',        'User');
Route::model('projeto',     'Projeto');
Route::model('servidor',    'Servidor');
Route::model('deploy',      'Deploy');

Route::get("login", "UsuarioController@loginForm");
Route::get("login/bitbucket", "UsuarioController@loginWithBitBucket");


Route::group(array("before" => "auth"), function()
{
	Route::get("/",                                 "HomeController@showWelcome");
	Route::get("home",                              "HomeController@showWelcome");
	Route::get("logout",                            "UsuarioController@logout");

    Route::get("projeto",                           "ProjetoController@index" );
    Route::get("projeto/{id}/deploys",              "ProjetoController@deploys" );

    Route::get("deploy/{projeto}/{sid}/create",         "DeployController@create" );
    Route::get("deploy/{projeto}/{sid}/fetch",          "DeployController@fetch" );
    Route::get("deploy/{projeto}/{sid}/clonar",         "DeployController@clonar" );
    Route::get("deploy/{projeto}/{sid}/dados",          "DeployController@dados" );
    Route::post("deploy/{projeto}/{sid}/realizar",      "DeployController@realizar" );
    Route::post("deploy/{id}/rollback",             array(
        "before" => "csrf", 
        "uses"   => "DeployController@rollback"
    ));
    
    Route::get("deploy/{projeto}/{sid}/remover",      "HelperController@remover_repositorio" );

    // Route::resource("projeto",                      "ProjetoController" );
    Route::resource("usuario",                      "UsuarioController" );
    Route::post("usuario/{id}/update",              "UsuarioController@update" );
});

Route::group(array("before" => "auth|admin"), function(){
    
    Route::get("projeto/create",                    "ProjetoController@create" );
    Route::get("projeto/{id}",                      "ProjetoController@show" );
    Route::get("projeto/{id}/edit",                 "ProjetoController@edit" );
    Route::post("projeto",                          array( "as" => "projeto.store", "uses" => "ProjetoController@store" ) );
    Route::put("projeto/{id}/update",              array( "as" => "projeto.update", "uses" => "ProjetoController@update" ) );

    Route::resource("servidor",                     "ServidorController" );
    Route::get("usuario/create",                    "UsuarioController@create" );
});