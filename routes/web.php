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

Route::get('/read', 'ItemsController@readFile');
Route::get('/extract', 'ItemsController@extract');
Route::get('/sources', 'SourcesController@index');
Route::post('/source/add', 'SourcesController@saveSource'); 
Route::post('/source/get', 'SourcesController@getSource'); /*Ajax Route*/
Route::post('/source/edit', 'SourcesController@editSource');
Route::get('/source/exec/{id}', 'SourcesController@executeSource');
Route::get('/feeds/{id}', 'FeedsController@runFeed');



/*
| -------------------------------------------------------
| Test Routes
| -------------------------------------------------------
*/

//Test Goutte
Route::get('/scrapetest', 'TestController@scrapeTest');

