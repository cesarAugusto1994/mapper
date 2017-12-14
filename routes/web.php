<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('user')->group(function () {
    Route::get('jobs', 'JobsController@index')->name('jobs');
    Route::get('job/{id}', 'JobsController@show')->name('job');
    Route::get('job/create/form', 'JobsController@create')->name('job_create');

    Route::post('job/store', 'JobsController@store')->name('job_store');

    Route::get('departments', 'DepartmentsController@index')->name('departments');
    Route::get('department/{id}', 'DepartmentsController@show')->name('department');
    Route::get('department/create/form', 'DepartmentsController@create')->name('department_create');
    Route::get('department/{id}/edit', 'DepartmentsController@edit')->name('department_edit');

    Route::post('department/create/store', 'DepartmentsController@store')->name('department_store');
    Route::post('department/{id}/update', 'DepartmentsController@update')->name('department_update');

    Route::get('process/{id}', 'ProcessesController@show')->name('process');
    Route::get('process/create/form', 'ProcessesController@create')->name('process_create');
    Route::post('process/create/store', 'ProcessesController@store')->name('processes_store');
    Route::get('process/{id}/edit', 'ProcessesController@edit')->name('process_edit');

    Route::get('users', 'UsersController@index')->name('users');
    Route::get('user/{id}', 'UsersController@show')->name('user');
    Route::get('users/create/form', 'UsersController@create')->name('user_create');

    Route::post('users/create/store', 'UsersController@store')->name('user_store');
});

