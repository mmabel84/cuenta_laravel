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
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/createbd', 'ServController@createbd')->middleware('auth:api');

Route::get('/addapp', 'ServController@addapp')->middleware('auth:api');

Route::get('/desactapp', 'ServController@desactapp')->middleware('auth:api');

Route::get('/modpaq', 'ServController@modpaq')->middleware('auth:api');

Route::get('/addpaq', 'ServController@addpaq')->middleware('auth:api');

Route::get('/getusr', 'ServController@returnUsersControl')->middleware('auth:api');

Route::get('/unlockusr', 'ServController@unlockUserControl')->middleware('auth:api');

Route::get('/getbit', 'ServController@getBitControl')->middleware('auth:api');
