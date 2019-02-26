<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/#Route::get('/{code}', array('as' => 'get', 'uses' => 'LinkController@get'));
Route::get('getLink/{id}', 'LinkController@getLink');
Route::put('changeLink/{id}', 'LinkController@changeLink');
Route::post('createLink', 'LinkController@createLink');
Route::delete('deleteLink/{id}', 'LinkController@deleteLink');
Route::get('showAllLinks', 'LinkController@showAllLinks');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
