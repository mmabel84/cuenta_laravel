<?php

use Illuminate\Http\Request;

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
Route::resource('backups', 'BackController');

Route::get('/', 'HomeController@index')->name('home');

Route::post('/addusrdb/{usrid}/{bdid}', 'UsrController@relateUsrApp')->name('relatedb');
Route::post('/addbdusr', 'AppController@relateAppUsr')->name('relateusr');
Route::post('/cambcont', 'UsrController@changepass')->name('cambiarcontrasena');

Route::post('/usuarios/permsbyroles', 'UsrController@permsbyroles');

Route::post('/usuarios/{usrid}/permsbyroles', 'UsrController@permsbyroles');

Route::post('/appbyemp', 'HomeController@appbyemp');
Route::post('/artconsult', 'HomeController@auditar69b')->name('art');

Route::get('/downloadback/{bdid}', 'BackController@downloadBackup')->name('downlback');

//Ruta para consumir servicio web que expone roles de BD de aplicación
Route::post('/getrolesbd/{bdid}', 'UsrController@getrolepermissionbd')->name('getrolesbd');


Auth::routes();






//--------------Rutas de autorización Passport--------------------------//





Route::get('/getcontrolaccesstoken', function () {
    $http = new GuzzleHttp\Client();
    $response = $http->post('http://advans.control.mx/oauth/token', [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => '5',
        'client_secret' => 'zYJPeZrqWbW1lAHl80b4Zn0fFYi2iZN6Unlgcdu6',
        'username' => 'chino270786@gmail.com',
        'password' => base64_decode('RGFuaWVsMTIz'),
        'scope' => '*',
    ],
]);
    $vartemp = json_decode((string) $response->getBody(), true);


    $responseotro = $http->get('http://advans.control.mx/api/firstservice', [
        'headers' => [
            'Authorization' => 'Bearer '.$vartemp['access_token'],
        ]
    ]);
    

    
return json_decode((string) $responseotro->getBody(), true);

});






