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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function () {

    Route::get('login', function () {
        return view('backend.auth.login');
    });
   
    Route::get('home', function () {
        return view('backend.dashboard');
    });

	Route::prefix('users')->group(function(){
    	Route::get('all','UserController@showAllUsers');
    });

    Route::prefix('quiz')->group(function(){
    	Route::get('create','QuizController@showCreateQuiz');
    	Route::get('save','QuizController@saveQuiz');
    	Route::get('edit/{id}','QuizController@showEditQuiz');
    	Route::get('all/{type?}','QuizController@showAllQuiz');
    });

    Route::prefix('question')->group(function(){
   		Route::get('create','QuestionController@showCreateQuestion');
   		Route::post('save','QuestionController@saveQuestion');
	    Route::get('edit/{id}','QuestionController@showEditQuestion');
	    Route::get('all/{type?}','QuestionController@showAllQuestion');
	});

        
});