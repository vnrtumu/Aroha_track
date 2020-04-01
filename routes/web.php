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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/history', 'UserLogController@history')->name('history');


Auth::routes(['verify' => true]);


Route::get('/home', 'HomeController@index')->middleware('verified');

Route::post('/create', 'UserLogController@create')->name('create');
Route::post('/update', 'UserLogController@update')->name('update');


Route::get('/sendemails', 'UserLogController@sendemails')->name('sendemails');


