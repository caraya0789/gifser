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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/favorites', 'HomeController@favorites')->name('favorites');
Route::get('/history', 'HomeController@history')->name('history');
Route::get('/view/{id}', 'HomeController@single')->name('single');
Route::get('/view', function() {
	return redirect('/');
});

Route::get('/api/search', 'HomeController@search')->name('search');
Route::get('/api/favorite', 'HomeController@favorite')->name('favorite');
