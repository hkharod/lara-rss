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


//Public Welcome Page

Route::get('/', function () {
    return view('welcome');
});


//Authentication Scaffold Routes

Auth::routes();


//Project Home 

Route::get('/home', 'HomeController@index')->name('home');


//Job Actions

Route::get('/job/edit/{id}', 'HomeController@editJob');
Route::get('/job/delete/{id}', 'HomeController@deleteJob');
Route::post('/job/publish/', 'HomeController@publishJob');
Route::post('/search', 'HomeController@search');
Route::get('/job/emailedit/{id}', 'HomeController@emailEdit');
Route::post('/job/emailpublish', 'HomeController@emailPublish');


//Source Actions

Route::get('/read', 'HomeController@readFile');
Route::get('/extract', 'HomeController@extract');
Route::get('/sources', 'SourcesController@index');
Route::post('/source/add', 'SourcesController@saveSource'); 
Route::post('/source/get', 'SourcesController@getSource'); /*Ajax Route*/
Route::post('/source/edit', 'SourcesController@editSource');
Route::get('/source/exec/{id}', 'SourcesController@executeSource');
Route::get('/feeds/{id}', 'FeedsController@runFeed');



//Test Controller 

//Test Goutte
Route::get('/scrapetest', 'TestController@scrapeTest');

//Test Feeds
