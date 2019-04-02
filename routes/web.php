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
    return view('home');
});

Route::post('create_csv', 'UserDetailsController@create')->name('create_csv');
Route::post('upload_file', 'UserDetailsController@upload_file')->name('upload_file');
Route::get('upload_file', 'UserDetailsController@import');
