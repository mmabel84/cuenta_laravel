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


Route::resource('empresas', 'EmprController');
Route::resource('usuarios', 'UsrController');
Route::resource('apps', 'AppController');
Route::resource('paqs', 'PaqController');
Route::resource('roles', 'RolController');
Route::resource('permisos', 'PermController');
Route::resource('bitacoras', 'BitController');
Route::resource('appsasign', 'AppAsignController');

Route::get('/', 'HomeController@index')->name('home');

Route::post('/addusrdb/{usrid}/{bdid}', 'UsrController@relateUsrApp')->name('relatedb');
Route::post('/addbdusr/{bdid}/{usrid}', 'AppController@relateAppUsr')->name('relateusr');

Route::post('/permsbyroles/{bdid}', 'AppController@relateAppUsr')->name('relateusr');

Auth::routes();

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://192.168.10.114:8000',
        'response_type' => 'code',
        'scope' => '',
    ]);

   return redirect('http://192.168.10.103:8000/oauth/authorize?'.$query);
});


