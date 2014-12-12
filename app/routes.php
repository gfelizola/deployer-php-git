<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get("login", "UsuarioController@loginForm");
Route::get("login/bitbucket", "UsuarioController@loginWithBitBucket");


Route::group(array("before" => "auth"), function()
{
	Route::get("/", 			"HomeController@showWelcome");
	Route::get("home", 			"HomeController@showWelcome");
	Route::get("logout", 		"UsuarioController@logout");

    Route::resource("deploy",  	"DeployController" );
    Route::resource("projeto",  "ProjetoController" );
    Route::resource("usuario",  "UsuarioController" );
});