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
    return view('auth/login');
});

Auth::routes();

Route::resource('herramientas','HerramientaController');
Route::resource('salidas','SalidaController');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('salidas/{id}/create', 'SalidaController@create');#se crea esta ruta custome porque se necesita el id como parametro
Route::post('salidas/{id}','SalidaController@update')->name('salida.update');
Route::post('herramientas/{id}','HerramientaController@update')->name('herramienta.update');


Route::get('Herramienta', 'HerramientaController@action')->name('live_search.action');
Route::get('Salida', 'SalidaController@action')->name('live_search_salidas.action');

#limpia cache
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return 'ROUTE CLEARED'; //Return anything
});
Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    //system('composer dump-autoload');
    return 'CACHE CLEARED'; //Return anything
});

