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

//Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index');

//});

//Route::get('/home', 'HomeController@index');

Route::get('authorization', 'AuthController@authorization')->middleware(['auth:api_auth']);
Route::group(['middleware' => 'auth:api_access'], function () {
    Route::resource('users', 'UsersController');
});


