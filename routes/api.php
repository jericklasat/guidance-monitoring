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

Route::prefix('/courses')->group(function () {
    Route::middleware('auth:api')->get('/all', 'ApiController@allCourses')->name('all_courses');
    Route::middleware('auth:api')->post('/search', 'ApiController@courseExist')->name('search_courses');
    Route::middleware('auth:api')->post('/add', 'ApiController@addCourse')->name('add_course');
});

Route::middleware('auth:api')->post('/register/', 'ApiController@registerStudent')->name('register_student');
Route::middleware('auth:api')->get('/retrieve/students', 'ApiController@fetchAllStudentsRecord')->name('all_students');
Route::middleware('auth:api')->post('/students/single', 'ApiController@fetchStudentById')->name('single_students');
Route::middleware('auth:api')->post('/students/update', 'ApiController@updateStudent')->name('update_students');

Route::prefix('/subject')->group(function () {
    Route::middleware('auth:api')->post('/check', 'ApiController@subjectExist')->name('check_subject');
    Route::middleware('auth:api')->post('/add', 'ApiController@addSubject')->name('add_subject');
    Route::middleware('auth:api')->get('/all', 'ApiController@fetchAllSubject')->name('all_subject');
});

Route::prefix('/violation')->group(function () {
    Route::middleware('auth:api')->post('/add', 'ApiController@addViolation')->name('add_violation');
    Route::middleware('auth:api')->get('/history', 'ApiController@violationHistory')->name('history_violation');
    Route::middleware('auth:api')->get('/total', 'ApiController@violationsTotal')->name('total_violation');
    Route::middleware('auth:api')->post('/student-id', 'ApiController@violationByStudentId')->name('violation_by_student_id');
    Route::middleware('auth:api')->post('/id', 'ApiController@violationsById')->name('violation_by_id');
    Route::middleware('auth:api')->post('/remove', 'ApiController@removeViolationById')->name('remove_violation_by_id');
});

Route::prefix('/email')->group(function () {
    Route::middleware('auth:api')->post('/send-notice', 'ApiController@sendEmailNotice')->name('send_email_notice');
});

Route::middleware('auth:api')->get('/sample', function(){
    $user = App\User::find(1);
    echo json_encode($user);
});

