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

Auth::routes();

Route::get('/', 'PageController@index')->name('index');
Route::prefix('student')->group(function () {
    Route::get('/', 'PageController@studentView')->name('student_view');
    Route::get('/register', 'PageController@studentRegister')->name('student_register');
    Route::get('/view/{id_number?}', 'PageController@studentSingleView')->name('student_single');
    Route::get('/update/{id_number?}', 'PageController@studentUpdate')->name('student_update');
});

Route::prefix('/violations')->group(function () {
    Route::get('/add', 'PageController@addViolations')->name('add_violation');
    Route::get('/view/{id_number?}', 'PageController@viewViolation')->name('view_violation');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/mail/view', function() {
    $data = [
        'violation' => 'Behaviour',
        'count' => '2',
        'yr_sem' => '2Y1',
        'subject' => 'ENGLISH 103',
        'type' => 'warning',
        'guardian_name' => 'Gildarts Clive',
        'gender' => 'Male',
        'std_fullname' => 'Icamina, Jerick Son Lasat'
    ];
    return new App\Mail\Notification($data);
});