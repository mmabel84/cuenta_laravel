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
Route::resource('certificados', 'CertController');
Route::get('certvencidos', 'CertController@indexvencidos')->name('certvencidos');
Route::get('appsprueba', 'AppController@indexprueba')->name('appsprueba');

Route::get('consulta69', 'Art69Controller@consulta69')->name('consulta69');
Route::post('request69consult', 'Art69Controller@request69consult')->name('request69consult');

Route::get('/', 'HomeController@index')->name('home');

Route::post('/addusrdb', 'UsrController@relateUsrApp')->name('relatedb');
Route::post('/addbdusr', 'AppController@relateAppUsr')->name('relateusr');
Route::post('/unrbdusr', 'AppController@unrelateAppUsr')->name('unrelateusr');

Route::post('/getbitbd', 'AppController@getBitBD')->name('getbitbd');

Route::post('/cambcont', 'UsrController@changepass')->name('cambiarcontrasena');

Route::post('/usuarios/permsbyroles', 'UsrController@permsbyroles');

Route::post('/usuarios/{usrid}/permsbyroles', 'UsrController@permsbyroles');

Route::post('/appbyemp', 'HomeController@appbyemp');
Route::post('/artconsult', 'HomeController@auditar69b')->name('art');

Route::get('/downloadback/{bdid}', 'BackController@downloadBackup')->name('downlback');
Route::get('/restoreback/{bdid}', 'BackController@restore')->name('restback');

//Ruta para consumir servicio web que expone roles de BD de aplicación
Route::post('/getrolesbd/{bdid}', 'UsrController@getrolepermissionbd')->name('getrolesbd');

Route::get('/redirectapp/{numcta}/{rfc}/{appcod}', 'HomeController@redirectapp')->name('redirectapp');

Route::post('/apps/getespdisp', 'AppController@getEspDisp')->name('getespdisp');

Route::post('/transfmegas', 'AppController@transfMegas')->name('transfmegas');

Route::post('/modifMegas', 'AppController@modifMegas')->name('modifMegas');




Auth::routes();






//--------------Rutas de autorización Passport--------------------------//





Route::get('/getcontrolaccesstoken', function () {
    $http = new GuzzleHttp\Client();
    $response = $http->post('http://advans.control.mx/oauth/token', [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => '1',
        'client_secret' => '98q5xAE0Pna6IWKLpNdn3gvQtXsP0ZsDqvn1ho9a',
        'username' => 'control.admin@advans.mx',
        'password' => 'Admin123*',
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






