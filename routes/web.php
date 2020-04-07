<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index');

// Auth::routes();

Route::name('admin.')->middleware(['admin'])->prefix('admin')->group(function () {

    Route::prefix('auth')->name('auth.')->group(function () {    
        Route::get('login', 'AdminUserController@showLogin')->name('login');
        Route::post('login', 'AdminUserController@login');
        Route::get('logout', 'AdminUserController@logout');
        Route::get('register','AdminUserController@showRegister')->name('register');
        Route::post('register', 'AdminUserController@register');
    });

    Route::get('home','AdminUserController@index')->name('home');

	Route::prefix('users')->group(function(){
    	Route::get('all','UserController@showAllUsers');
    });

    Route::prefix('quiz')->group(function(){
    	Route::get('create','QuizController@showCreateQuiz');
        Route::post('create','QuizController@createQuiz');
    	Route::get('save','QuizController@saveQuiz');
    	Route::get('edit/{id}','QuizController@showEditQuiz');
        Route::post('edit/{id}','QuizController@saveEditQuiz');
    	Route::get('all/{type?}','QuizController@showAllQuiz');
    });

    Route::prefix('question')->group(function(){
   		Route::get('create','QuestionController@showCreateQuestion');
   		Route::post('create','QuestionController@createQuestion');
	    Route::get('edit/{id}','QuestionController@showEditQuestion');
        Route::post('edit/{id}','QuestionController@saveEditQuestion');
	    Route::get('all/{type?}','QuestionController@showAllQuestion');
        Route::get('delete/{id}','QuestionController@deleteQuestion');
	});

    Route::prefix('course')->group(function(){
        Route::get('create','CourseController@showCreateCourse');
        Route::post('create','CourseController@createCourse');
        Route::get('edit/{id}','CourseController@showEditCourse');
        Route::post('edit/{id}','CourseController@saveEditCourse');
        Route::get('show/{id}','CourseController@showCourse');
        Route::get('all/{type?}','CourseController@showAllCourse');
        Route::get('delete/{id}','CourseController@deleteCourse');
    });

    Route::prefix('topic')->group(function(){
        Route::get('create/{courseName?}','TopicController@showCreateCourseTopic');
        Route::post('create','TopicController@createCourseTopic');
        Route::get('edit/{id}','TopicController@showEditCourseTopic');
        Route::post('edit/{id}','TopicController@saveEditCourseTopic');
        Route::get('all/{courseName}','TopicController@showAllCourseTopic');
        Route::get('delete/{id}','TopicController@deleteCourseTopic');
    });
     Route::prefix('resource')->group(function(){
        Route::get('create/{topicId}','ResourceController@showCreateResource');
        Route::post('create/{topicId}','ResourceController@createResource');
        Route::get('edit/{id}','ResourceController@showEditResource');
        Route::post('edit/{id}','ResourceController@saveEditResource');
        Route::get('all','ResourceController@showAllResource');
        Route::get('delete/{id}','ResourceController@deleteResource');
    });

});
// Route::fallback(function () {
//     return redirect()->guest('/');
// });