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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'UserAuthController@register');
Route::post('login', 'UserAuthController@login');
Route::post('update-user', 'UserAuthController@updateUserData');
Route::post('check-username', 'UserAuthController@checkUserName');

Route::post('get-courses', 'CourseController@wsGetAllCourses');
Route::post('get-topics', 'TopicController@wsGetAllTopics');
Route::post('get-resources', 'ResourceController@wsGetAllResources');

