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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/activity', 'FormController@activityEntry');
Route::post('/workouts/storeAcitivy', 'FormController@storeAcitivy');
Route::post('/addActivity', 'FormController@addActivity');
Route::post('/updateActivity', 'FormController@updateActivity');
Route::post('/deleteActivity', 'FormController@deleteActivity');
Route::post('/addItem', 'FormController@addItem');
Route::post('/updateItem', 'FormController@updateItem');
Route::post('/deleteItem', 'FormController@deleteItem');
Route::post('/deleteTarget', 'FormController@deleteTarget');
Route::post('/workouts/storeAlcohol', 'FormController@storeAlcohol');
Route::post('/workouts/storeSnack', 'FormController@storeSnack');
Route::post('/workouts/storeSleep', 'FormController@storeSleep');
Route::post('/workouts/storeMood', 'FormController@storeMood');
Route::post('/workouts/storeWeight', 'FormController@storeWeight');
Route::post('/addTarget', 'FormController@addTarget');
Route::get('/alcohol', 'FormController@alcoholEntry');
Route::get('/snack', 'FormController@snackEntry');
Route::get('/item', 'FormController@itemEntry');
Route::get('/sleep', 'FormController@sleepEntry');
Route::get('/mood', 'FormController@moodEntry');
Route::get('/weight', 'FormController@weightEntry');
Route::get('/calendar', 'FormController@calendar');
Route::get('/statistics', 'FormController@statistics');
Route::post('/getColor', 'FormController@getColor');
Route::post('/checkActivities', 'FormController@checkActivities');
Route::post('/checkItems', 'FormController@checkItems');

