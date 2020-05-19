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
    return view('frontend.share.app',['type'=>'home']);
});

Route::get('terms-and-conditions',function(){
    return view('frontend.termsAndConditions');
});

Route::name('share.')->group(function () {
    Route::get('install','ShareController@share');
    Route::get('resource/{id}','ShareController@shareResource');
    Route::get('project/{id}','ShareController@shareProject'); 
    Route::get('course/{id}','ShareController@shareCourse'); 
});

Route::get('ray','NotificationController@sendAndroidNotification');



Route::get('resetPassword','AdminUserController@showResetPassword')->name('showResetPassword')->middleware('signed');
Route::post('resetPassword','AdminUserController@resetPassword')->name('resetPassword');

Route::get('verify','AdminUserController@verifyEmail')->name('showVerify');

Route::name('admin.')->prefix('admin')->group(function () {

    Route::prefix('auth')->name('auth.')->group(function () {    
        Route::get('login', 'AdminUserController@showLogin')->name('login')->middleware('guest:admin');
        Route::post('login', 'AdminUserController@login');
        Route::get('logout', 'AdminUserController@logout');
        Route::get('register','AdminUserController@showRegister')->name('register');
        Route::post('register', 'AdminUserController@register');
        Route::get('forgot','AdminUserController@showForgotPassword')->name('showforgotPassword');
        Route::post('forgot','AdminUserController@forgotPassword')->name('forgotPassword');
    });

    Route::middleware(['auth:admin'])->group(function(){

        Route::any('froala/upload-image','AdminUserController@uploadImageFroalaEditor');
        Route::get('home','AdminUserController@index')->name('home');

        Route::prefix('manage')->group(function(){
            Route::get('all','AdminUserController@manage')->name('manage');
            Route::post('create','AdminUserController@createAdmin');
        });

        Route::prefix('users')->name('users.')->group(function(){
            Route::get('all/{type?}','UserController@showAllUsers')->name('all');
            Route::get('show/{id}','UserController@showUser');
            Route::post('delete','UserController@deleteUser');
        });

        Route::name('quiz.')->prefix('quiz')->group(function(){
            Route::get('create','QuizController@showCreateQuiz');
            Route::post('create','QuizController@createQuiz');
            Route::get('edit/{id}','QuizController@showEditQuiz');
            Route::post('edit/{id}','QuizController@saveEditQuiz');
            Route::get('all/{type?}','QuizController@showAllQuiz');
        });

        Route::name('question.')->prefix('question')->group(function(){
            Route::get('create','QuestionController@showCreateQuestion');
            Route::post('create','QuestionController@createQuestion');
            Route::get('edit/{id}','QuestionController@showEditQuestion');
            Route::post('edit/{id}','QuestionController@saveEditQuestion');
            Route::get('all/{type?}','QuestionController@showAllQuestion');
            Route::get('delete/{id}','QuestionController@deleteQuestion');
        });

        Route::name('course.')->prefix('course')->group(function(){
            Route::get('create','CourseController@showCreateCourse');
            Route::post('create','CourseController@createCourse');
            Route::get('edit/{id}','CourseController@showEditCourse');
            Route::post('edit/{id}','CourseController@saveEditCourse');
            Route::get('show/{id}','CourseController@showCourse');
            Route::get('all/{type?}','CourseController@showAllCourse');
            Route::get('delete/{id}','CourseController@deleteCourse');

            Route::post('publish','CourseController@publishCourse')->name('publish');
             Route::post('sequence','CourseController@changeCourseSequence')->name('sequence');
        });

        Route::name('courseTopic.')->prefix('topic')->group(function(){
            Route::get('create/{courseName?}','TopicController@showCreateCourseTopic');
            Route::post('create','TopicController@createCourseTopic');
            Route::get('edit/{id}','TopicController@showEditCourseTopic');
            Route::post('edit/{id}','TopicController@saveEditCourseTopic');
            Route::get('all/{courseName?}','TopicController@showAllCourseTopic');
            Route::post('delete','TopicController@deleteCourseTopic');
            Route::post('sequence','TopicController@changeCourseTopicSequence')->name('sequence');

            Route::post('publish','TopicController@publishCourseTopic')->name('publish');
            Route::get('publish/{courseId}','TopicController@publishAllCourseTopic');
        });
        Route::name('resource.')->prefix('resource')->group(function(){
            Route::get('create/{topicId}','ResourceController@showCreateResource');
            Route::post('create/{topicId}','ResourceController@createResource');
            Route::get('edit/{id}','ResourceController@showEditResource');
            Route::post('edit/{id}','ResourceController@saveEditResource');
            Route::get('all/{topicId?}','ResourceController@showAllResource');
            Route::post('delete','ResourceController@deleteResource')->name('delete');
        });
        Route::name('project.')->prefix('project')->group(function(){
           Route::get('create/{course_name?}','ProjectController@showCreateProject');
           Route::post('create','ProjectController@createProject');
           Route::get('edit/{id}','ProjectController@showEditProject');
           Route::post('edit/{id}','ProjectController@saveEditProject');
           Route::get('all/{course_name?}','ProjectController@showAllProject');
           Route::post('delete','ProjectController@deleteProject')->name('delete');
           Route::post('sequence','ProjectController@changeProjectSequence')->name('sequence');

           Route::post('publish','ProjectController@publishProject')->name('publish');
            Route::get('publish/{courseId}','ProjectController@publishAllProject');
       });

        Route::name('banner.')->prefix('banner')->group(function(){
            Route::get('create','BannerController@showCreateBanner');
            Route::post('create','BannerController@createBanner');
            Route::get('show','BannerController@showbanner');

            Route::get('edit/{id}','BannerController@showEditBanner');
            Route::post('edit/{id}','BannerController@saveEditBanner');

            Route::post('delete','BannerController@deleteBanner')->name('delete');
            Route::get('delete/{id}','BannerController@deleteBanner');
            Route::post('publish','BannerController@publishBanner')->name('publish');
        });
        Route::name('notification.')->prefix('notification')->group(function(){
            Route::get('show','NotificationController@showNotification');
            Route::post('test','NotificationController@sendTestNotification');
            Route::post('send','NotificationController@sendAndroidNotification');

        });
        Route::name('email.')->prefix('email')->group(function()
        {
            Route::get('/compose/{id?}','EmailController@showComposeEmail');
            Route::get('/','EmailController@showEmail'); 


            Route::post('/save','EmailController@saveCustomEmail'); 
            Route::post('/send','EmailController@sendCustomEmailToAll');
            Route::post('/test','EmailController@sendTestCustomEmail');
        });

    });
});