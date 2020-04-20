<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'UserAuthController@register');
Route::post('login', 'UserAuthController@login');

Route::middleware(['auth.jwt','verify'])->group(function () {
 	Route::post('user','UserAuthController@getUser');
	Route::post('update-user', 'UserAuthController@updateUserData');
	Route::post('check-username', 'UserAuthController@checkUserName');
	Route::post('get-courses', 'CourseController@wsGetAllCourses');
	Route::post('get-topics', 'TopicController@wsGetAllTopics');
	Route::post('get-resources', 'ResourceController@wsGetAllResources');
	Route::post('get-projects', 'ProjectController@wsGetAllProjects');
	Route::post('hit-like', 'ResourceProjectLikesController@wsHitlike');
	Route::post('view-resource', 'ResourceController@wsViewResource');
	Route::post('view-project', 'ProjectController@wsViewProject');
	Route::post('get-all-preferences', 'CourseController@wsGetAllPreferences');
	Route::post('update-password', 'UserAuthController@updatePassword');
});

Route::post('forget-password', 'UserAuthController@forgetPassword');
