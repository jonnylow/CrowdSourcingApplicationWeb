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

Route::get('home', ['middleware' => 'auth', 'uses' => 'Activities\ActivitiesController@index']);

Route::group(['middleware' => 'auth', 'namespace' => 'Profiles', 'prefix' => 'profile'], function() {
    Route::get('/', 'ProfileController@edit');
    Route::post('/', 'ProfileController@update');
    Route::get('password', 'ProfileController@editPassword');
    Route::post('password', 'ProfileController@updatePassword');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Activities'], function() {
    Route::post('postal-to-address', 'ActivitiesController@postalCodeToAddress');
    Route::get('activities/{activities}/{volunteer}/{approval}', 'ActivitiesController@approval');
    Route::resource('activities', 'ActivitiesController');
});

Route::group(['namespace' => 'Auth'], function() {
    Route::group(['prefix' => 'auth'], function() {
        // Authentication routes
        Route::get('login', 'AuthController@getLogin');
        Route::post('login', 'AuthController@postLogin');
        Route::get('logout', 'AuthController@getLogout');
    });

    Route::group(['prefix' => 'password'], function() {
        // Password reset link request routes
        Route::get('email', 'PasswordController@getEmail');
        Route::post('email', 'PasswordController@postEmail');

        // Password reset routes
        Route::get('reset/{token}', 'PasswordController@getReset');
        Route::post('reset', 'PasswordController@postReset');
    });
});

// Web service routes
Route::group(['namespace' => 'WebService', 'prefix' => 'api'], function() {
    Route::post('authenticate', 'VolunteerAuthController@authenticate');
    Route::get('retrieveTransportActivity', 'ActivitiesController@retrieveTransportActivity');
    Route::get('retrieveTransportActivityDetails', 'ActivitiesController@retrieveTransportActivityDetails');

    Route::get('retrieveRecommendedTransportActivity', 'ActivitiesController@retrieveRecommendedTransportActivity');
    Route::get('addNewActivity', 'ActivitiesController@addNewActivity');
    Route::get('checkActivityApplication', 'ActivitiesController@checkActivityApplication');
    Route::get('updateActivityStatus', 'ActivitiesController@updateActivityStatus');
    Route::get('withdraw', 'ActivitiesController@withdraw');


    Route::get('addUserAccount', 'VolunteerController@addUserAccount');
    Route::get('checkEmail', 'VolunteerController@checkEmail');
    Route::get('checkNRIC', 'VolunteerController@checkNRIC');
    Route::get('retrieveUserAccounts', 'VolunteerController@retrieveUserAccounts');
    Route::get('retrieveUserDetails', 'VolunteerController@retrieveUserDetails');
    Route::get('verifyUserEmailandPassword', 'VolunteerController@verifyUserEmailandPassword');
    

    Route::get('retrieveElderyInformation', 'ElderlyController@retrieveElderyInformation');


});
