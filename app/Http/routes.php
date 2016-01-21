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

Route::get('/', ['middleware' => 'guest', 'uses' => 'Auth\AuthController@getLogin']);

Route::get('home', ['middleware' => 'auth', 'uses' => 'Activities\ActivitiesController@index']);

Route::get('rank', ['middleware' => 'auth', 'uses' => 'Ranks\RankController@index']);

Route::group(['middleware' => 'auth', 'namespace' => 'Profiles', 'prefix' => 'profile'], function() {
    Route::get('/', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::patch('/', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::get('password', ['as' => 'profile.edit.password', 'uses' => 'ProfileController@editPassword']);
    Route::patch('password', ['as' => 'profile.update.password', 'uses' => 'ProfileController@updatePassword']);
});

Route::group(['middleware' => 'auth', 'namespace' => 'Activities'], function() {
    Route::patch('activities/{activities}/approve/{volunteer}', ['as' => 'activities.approve.volunteer', 'uses' => 'ActivitiesController@approveVolunteer']);
    Route::patch('activities/{activities}/reject/{volunteer}', ['as' => 'activities.reject.volunteer', 'uses' => 'ActivitiesController@rejectVolunteer']);
    Route::resource('activities', 'ActivitiesController');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Volunteers'], function() {
    Route::patch('volunteers/{volunteers}/approve', ['as' => 'volunteers.approve', 'uses' => 'VolunteersController@approveVolunteer']);
    Route::patch('volunteers/{volunteers}/reject', ['as' => 'volunteers.reject', 'uses' => 'VolunteersController@rejectVolunteer']);
    Route::resource('volunteers', 'VolunteersController');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Elderly'], function() {
    Route::resource('elderly', 'ElderlyController');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Staff'], function() {
    Route::resource('staff', 'StaffController');
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

    Route::get('addUserAccount', 'VolunteerController@addUserAccount');
    Route::get('checkEmail', 'VolunteerController@checkEmail');
    Route::get('checkNRIC', 'VolunteerController@checkNRIC');
    Route::get('retrieveUserAccounts', 'VolunteerController@retrieveUserAccounts');
    Route::get('retrieveUserDetails', 'VolunteerController@retrieveUserDetails');
});
