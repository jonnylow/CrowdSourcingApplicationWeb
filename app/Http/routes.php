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

Route::get('home', function () {
    return view('home');
});

Route::get('/', function () {
    return view('auth.login');
});

Route::group(array('namespace' => 'Auth', 'prefix' => 'auth'), function() {
    // Authentication routes...
    Route::get('login', 'AuthController@getLogin');
    Route::post('login', 'AuthController@postLogin');
    Route::get('logout', 'AuthController@getLogout');
});

Route::group(array('namespace' => 'WebService', 'prefix' => 'api'), function() {
    Route::post('authenticate', 'VolunteerAuthController@authenticate');
});
