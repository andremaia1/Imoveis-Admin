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

Route::group(['middleware' => 'administrador'], function () {
    
    Route::get('/admin/login', 'AdministradorController@login');
    Route::post('/admin/logar', 'AdministradorController@logar')->name('admin.logar');
    
    Route::group(['middleware' => 'auth:administrador'], function () {
        
        Route::get('/admin', 'AdministradorController@index');
        Route::get('/admin/logout', 'AdministradorController@logout')->name('admin.logout');
        
        Route::resource('admins', 'AdministradorController');
        Route::resource('users', 'UsuarioController');
        Route::get('/usuarios/lista', 'UsuarioController@lista')->name('usuarios.lista');
        Route::get('/usuarios/alterar_status/{id}', 'UsuarioController@alterarStatus')->name('usuarios.alterar_status');
    });
});

Route::group(['middleware' => 'usuario'], function () {
    
    Route::get('/', 'UsuarioController@login')->name('usuario.login');
    Route::post('/usuario/logar', 'UsuarioController@logar')->name('usuario.logar');
    
    Route::group(['middleware' => 'auth:usuario'], function () {
        
        Route::get('/usuario', 'UsuarioController@index');
        Route::get('/usuario/logout', 'UsuarioController@logout')->name('usuario.logout');
        Route::resource('imoveis', 'ImovelController');
    });
});

Auth::routes();
