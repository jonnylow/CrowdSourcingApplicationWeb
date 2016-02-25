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

Route::group(['middleware' => 'auth', 'namespace' => 'Stats'], function() {
    Route::get('stats', ['as' => 'stats.index', 'uses' => 'StatsController@index']);
    Route::get('stats/getMainCharts', 'StatsController@ajaxRetrieveMainCharts');
    Route::get('stats/getSubCharts', 'StatsController@ajaxRetrieveSubCharts');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Ranks'], function() {
    Route::get('rank', ['as' => 'ranks.index', 'uses' => 'RankController@index']);
    Route::patch('rank', ['as' => 'ranks.update', 'uses' => 'RankController@update']);
});

Route::group(['middleware' => 'auth', 'namespace' => 'Profiles', 'prefix' => 'profile'], function() {
    Route::get('/', ['as' => 'profile.view', 'uses' => 'ProfileController@view']);
    Route::get('password', ['as' => 'profile.edit.password', 'uses' => 'ProfileController@editPassword']);
    Route::patch('password', ['as' => 'profile.update.password', 'uses' => 'ProfileController@updatePassword']);
});

Route::group(['middleware' => 'auth', 'namespace' => 'Activities'], function() {
    Route::patch('activities/{activities}/approve/{volunteer}', ['as' => 'activities.approve.volunteer', 'uses' => 'ActivitiesController@approveVolunteer']);
    Route::patch('activities/{activities}/reject/{volunteer}', ['as' => 'activities.reject.volunteer', 'uses' => 'ActivitiesController@rejectVolunteer']);
    Route::get('activities/cancelled', ['as' => 'activities.cancelled', 'uses' => 'ActivitiesController@showCancelled']);
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
        Route::get('email', ['as' => 'password.request.index', 'uses' => 'PasswordController@getEmail']);
        Route::post('email', ['as' => 'password.request', 'uses' => 'PasswordController@postEmail']);

        // Password reset routes
        Route::get('reset/{token}', ['as' => 'password.reset.index', 'uses' => 'PasswordController@getReset']);
        Route::post('reset', ['as' => 'password.reset', 'uses' => 'PasswordController@postReset']);
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
    Route::get('retrieveFilter', 'ActivitiesController@retrieveFilter');
    Route::get('retrieveTransportByUser', 'ActivitiesController@retrieveTransportByUser');

    Route::get('addUserAccount', 'VolunteerController@addUserAccount');
    Route::get('checkEmail', 'VolunteerController@checkEmail');
    Route::get('checkNRIC', 'VolunteerController@checkNRIC');
    Route::get('retrieveUserAccounts', 'VolunteerController@retrieveUserAccounts');
    Route::get('retrieveUserDetails', 'VolunteerController@retrieveUserDetails');
    Route::get('verifyUserEmailandPassword', 'VolunteerController@verifyUserEmailandPassword');
    Route::get('updateUserAccount', 'VolunteerController@updateUserAccount');
    Route::get('updateUserDetails', 'VolunteerController@updateUserDetails');
    Route::get('retrieveMyTransportActivityDetails', 'VolunteerController@retrieveMyTransportActivityDetails');
    Route::get('retrieveRankingDetails', 'VolunteerController@retrieveRankingDetails');
    Route::get('graphInformation', 'VolunteerController@graphInformation');
    Route::get('getAllVolunteerContribution', 'VolunteerController@getAllVolunteerContribution');
    

    Route::get('retrieveElderyInformation', 'ElderlyController@retrieveElderyInformation');

    
});
