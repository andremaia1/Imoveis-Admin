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

Route::group(['middleware' => 'administrador'], function () {
    
    Route::get('/admin/login', 'AdministradorController@login');
    Route::post('/admin/logar', 'AdministradorController@logar')->name('adm.logar');
    
    Route::group(['middleware' => 'auth:administrador'], function () {
        
        Route::get('/admin', 'AdministradorController@index');
        Route::get('/admin/logout', 'AdministradorController@logout')->name('adm.logout');
    });
});

Auth::routes();
