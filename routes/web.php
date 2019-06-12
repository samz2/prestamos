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
    return view('auth.register');
}); 
Route::get('/login', function () {
    return view('/home');
})->middleware('checkAuth');; 
Auth::routes();
Route::get('/buscar', function () {
    return view('auth.buscar');
}); 
Route::get('/solicitud', function () {
    return view('solicitud');
}); 
// Route::get('/home', 'HomeController@index')->name('home');
//rutas administrador
Route::post('/addCliente', 'ClienteController@store');
Route::get('/getClientes', 'ClienteController@index');
Route::get('/getCliente', 'ClienteController@create');
Route::get('/getNombres/{dni}', 'ClienteController@show');
Route::get('/deleteCliente/{id}', 'ClienteController@destroy');
Route::get('/getConfianza/{id}', 'ClienteController@getConfianza');
Route::post('/addPrestamo', 'PrestamoController@store');
Route::get('/cronograma/{v}/{i}/{pr}/{pe}', 'PrestamoController@create');
Route::get('/getPrestamos/{id}', 'PrestamoController@getPrestamos');
Route::get('/getPrestamosGeneral/{id}', 'PrestamoController@index');
Route::get('/verReporte/{id}', 'CronogramaController@show');
Route::get('/getCuota/{id}', 'CronogramaController@getCuota');
Route::post('/addPago', 'PagoController@store');
Route::get('/getPagos/{i}/{f}', 'PagoController@index');
Route::post('/addSolicitud', 'SolicitudController@store');
Route::get('/getSolicitudes', 'SolicitudController@index');
Route::get('/getSolicitudC/{dni}', 'SolicitudController@show');
Route::get('/rechazarSolicitud/{id}/{motivo}', 'SolicitudController@rechazarSolicitud');
Route::get('/getCliente/{id}/', 'SolicitudController@getCliente');
Route::get('/getSolicitud/{dni}', 'CronogramaController@PDF');
Route::get('/getDatos', 'PrestamoController@datos');
//fin rutas administrador

// Rutas alternas
Route::get('{path}', 'HomeController@index')/*->where('path', '([A-z\d-\/_.]+)?')*/;

//rutas para admin/predio