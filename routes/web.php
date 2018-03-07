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

//	Route::resource('documents', 'DocumentsController');


Auth::routes();

Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

Route::group(['middleware' => 'auth'], function(){	
	Route::resource('documents', 'DocumentsController');
	Route::get('/', 'DocumentsController@index')->name('index');	
	Route::post('search',['as'=> 'search', 'uses' => 'SearchController@search']);
	Route::get('/{filename}',['as' => 'download','uses' => 'DocumentsController@download']);	
});
