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


Route::get('/', 'HomeController@index')->name('home');

Route::get('/listaempresa','EmprController@index')->name('listempr');

Route::get('/saveemp','EmprController@save');

Route::get('/delempresa/{id}','EmprController@delete')->name('delempr');




Route::get('/listarfc', function () {
    return view('listarfc');
});

Route::get('/rfcempresa', function () {
    return view('rfcempresa');
});

Route::get('/listausuario', function () {
    return view('listausuario');
});

Route::get('/usuario', function () {
    return view('usuario');
});

Route::get('/listainstancia', function () {
    return view('listainstancia');
});

Route::get('/instancia', function () {
    return view('instancia');
});

Route::get('/listaproveedor', function () {
    return view('listaproveedor');
});

Route::get('/proveedor', function () {
    return view('proveedor');
});
Auth::routes();


