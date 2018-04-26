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


/*
| -------------------------------------------------------
| Public Routes
| -------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
| -------------------------------------------------------
| Authentication Scaffold
| -------------------------------------------------------
*/

Auth::routes();


/*
| -------------------------------------------------------
| Item Routes & User Home
| -------------------------------------------------------
*/

Route::get('/home', 'ItemsController@index');
Route::get('/job/edit/{id}', 'ItemsController@editJob');
Route::get('/job/delete/{id}', 'ItemsController@deleteJob');
Route::post('/search', 'ItemsController@search');


/*
| -------------------------------------------------------
| Source Routes
| -------------------------------------------------------
*/

Route::get('/sources', 'SourcesController@index');
Route::post('/source/add', 'SourcesController@saveSource'); 
Route::post('/source/get', 'SourcesController@getSource'); 
Route::post('/source/edit', 'SourcesController@editSource');
Route::post('/source/delete', 'SourcesController@deleteSource');
Route::get('/source/execute/{id}', 'SourcesController@executeSource');



