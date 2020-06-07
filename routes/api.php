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
Route::post('social-register', 'UserAuthController@socialRegisterLogin');
Route::post('login', 'UserAuthController@login');
Route::post('forget-password', 'UserAuthController@forgetPassword');
Route::post('resend-verification-mail', 'UserAuthController@wsResendVerificationMail');

Route::middleware(['auth.jwt','verify'])->group(function () {

	Route::post('user','UserAuthController@getUser');
	Route::post('update-user', 'UserAuthController@updateUserData');
	Route::post('check-username', 'UserAuthController@checkUserName');
	Route::post('get-courses', 'CourseController@wsGetAllCourses');
	Route::post('get-topics', 'TopicController@wsGetAllTopics');
	Route::post('get-suggested-topics', 'TopicController@wsGetAllSuggestedTopics');
	Route::post('get-resources', 'ResourceController@wsGetAllResources');
	Route::post('get-banner', 'BannerController@wsGetBanner');
	Route::post('resource', 'ResourceController@wsGetResource');
	Route::post('get-projects', 'ProjectController@wsGetAllProjects');
	Route::post('project', 'ProjectController@wsGetProject');
	Route::post('get-suggested-projects','ProjectController@wsGetAllSuggestedProjects');
	Route::post('hit-like', 'ResourceProjectLikesController@wsHitlike');
	Route::post('view-resource-project', 'ResourceProjectViewsController@wsViewResource');
	Route::post('get-all-preferences', 'CourseController@wsGetAllPreferences');
	Route::post('update-password', 'UserAuthController@updatePassword');
	Route::post('store-feedback', 'UserFeedbackController@storeFeedback');

	Route::post('get-home-page', 'UserAuthController@wsGetHomePage');
	Route::post('get-my-liked-things','ResourceProjectLikesController@wsGetMyLikedThing');

	Route::post('search' , 'SearchController@search');
	Route::post('search-without-pagination' , 'SearchController@searchWithOutPagination');
	Route::post('update-user-preferences','UserAccountController@updateUserPreferences');
	Route::post('rate-course','UserAccountController@rateCourse');

	Route::post('course', 'CourseController@wsGetCourse');
	Route::post('add-to-user-preferences','UserAccountController@addToUserPreferences');
	Route::post('get-user-preferences','UserAccountController@listUserPreferences');

	Route::post('get-quiz','QuestionController@getQuiz');

});

