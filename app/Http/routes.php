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

Route::get('/', ['middleware' => 'guest', function () {
    return view('auth.login');
}]);

Route::get('home', ['middleware' => 'auth', function () {
    return view('home');
}]);

Route::get('profile', ['middleware' => 'auth', function () {
    return view('profile.profile');
}]);

Route::post('profile', 'Profile\ProfileController@editProfile');

Route::group(array('namespace' => 'Auth'), function() {
    Route::group(array('prefix' => 'auth'), function() {
        // Authentication routes...
        Route::get('login', 'AuthController@getLogin');
        Route::post('login', 'AuthController@postLogin');
        Route::get('logout', 'AuthController@getLogout');
    });

    Route::group(array('prefix' => 'password'), function() {
        // Password reset link request routes...
        Route::get('email', 'PasswordController@getEmail');
        Route::post('email', 'PasswordController@postEmail');

        // Password reset routes...
        Route::get('reset/{token}', 'PasswordController@getReset');
        Route::post('reset', 'PasswordController@postReset');
    });
});

Route::group(array('namespace' => 'WebService', 'prefix' => 'api'), function() {
    Route::post('authenticate', 'VolunteerAuthController@authenticate');
});
