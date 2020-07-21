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

Route::get('/wx/token','TestController@index');

Route::get('/wx/getwxtoken','TestController@getwxtoken');

Route::get('/getwww','TestController@getwww');
Route::get('/goods','TestController@goods');

Route::get('/kkk','RegController@kkk');

Route::post('/regpost','RegController@regpost');

Route::post('/loginpost','RegController@loginpost');

Route::get('/center','RegController@center')->middleware('accesstoken');
Route::get('/apiredis','RegController@apiredis');


Route::get('/kucun','RegController@kucun')->middleware('accesstoken');
Route::get('/qiandao','RegController@qiandao')->middleware('accesstoken');


