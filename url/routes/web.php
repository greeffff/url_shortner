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

Route::get('/', array('as' =>'home', 'uses'=> 'HomeController@index'));
Route::post('/make', array('as'=>'make','uses'=>'LinkController@make'));
Route::get('/{code}', array('as' => 'get', 'uses' => 'LinkController@get'));
Route::get('/swagger/doc', 'SwaggerController@doc');
