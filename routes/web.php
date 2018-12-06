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

//Grupo de rotas dos administradores
Route::group(['middleware' => 'administrador'], function () {
    
    Route::get('/admin/login', 'AdministradorController@login');
    Route::post('/admin/logar', 'AdministradorController@logar')->name('admin.logar');
    
    //Grupo de rotas dos administradores autenticados
    Route::group(['middleware' => 'auth:administrador'], function () {
        
        Route::get('/admin', 'AdministradorController@index');
        Route::get('/admin/logout', 'AdministradorController@logout')->name('admin.logout');
        
        Route::resource('admins', 'AdministradorController');
        Route::resource('users', 'UsuarioController');
        Route::get('/usuarios/lista', 'UsuarioController@lista')->name('usuarios.lista');
        Route::get('/usuarios/alterar_status/{id}', 'UsuarioController@alterarStatus')->name('usuarios.alterar_status');
        Route::get('/usuarios/listar_imoveis/{id}', 'UsuarioController@listaImoveisToAdmin')->name('usuarios.listar_imoveis');
        Route::get('/usuarios/ver_imovel/{id}', 'UsuarioController@verImovelAdmin')->name('usuarios.ver_imovel');
        Route::resource('relatErros', 'RelatorioErroController');
        Route::get('/relatErros/alterar_status/{id}', 'RelatorioErroController@alterarStatus')->name('relatErros.alterar_status');
        Route::get('grafImoveisUf', 'ImovelController@grafImoveisUfToAdmin')->name('graf.imoveisUf');
    });
});

//Grupo de rotas dos usuários
Route::group(['middleware' => 'usuario'], function () {
    
    Route::get('/', 'UsuarioController@login')->name('usuario.login');
    Route::post('/usuario/logar', 'UsuarioController@logar')->name('usuario.logar');
    Route::post('/usuario/cadastrar', 'UsuarioController@store')->name('usuario.cadastrar');
    
    //Grupo de rotas dos usuários autenticados
    Route::group(['middleware' => 'auth:usuario'], function () {
        
        Route::get('/usuario', 'UsuarioController@index')->name('usuario.index');
        Route::get('/usuario/logout', 'UsuarioController@logout')->name('usuario.logout');
        Route::get('/usuario/edit/{id}', 'UsuarioController@edit')->name('usuario.edit');
        Route::put('/usuario/update/{id}', 'UsuarioController@update')->name('usuario.update');
        Route::delete('/usuario/destroy/{id}', 'UsuarioController@destroy')->name('usuario.destroy');
        Route::resource('imoveis', 'ImovelController');
        Route::resource('locacoes', 'LocacaoController');
        Route::get('locatario/ver/{id}', 'LocatarioController@show')->name('locatario.ver');
        Route::get('pagamentos/{id}/{opcao}', 'PagamentoController@lista')->name('pagamentos.lista');
        Route::get('pagamento/ver/{id}', 'PagamentoController@ver')->name('pagamentos.ver');
        Route::get('pagamento/editar/{id}/{opcao}', 'PagamentoController@editar')->name('pagamentos.editar');
        Route::put('pagamento/atualizar/{id}/{opcao}', 'PagamentoController@atualizar')->name('pagamentos.atualizar');
        Route::post('pagamentos/gerar/{id}/{opcao}', 'PagamentoController@gerar')->name('pagamentos.gerar');
        Route::resource('condominios', 'CondominioController');
        Route::get('imobiliaria/ver/{id}', 'ImobiliariaController@ver')->name('imobiliaria.ver');
        Route::resource('despesas', 'DespesaController');
        Route::resource('multas', 'MultaController');
        Route::get('grafValorLocacoes', 'ImovelController@grafValorLocacoes')->name('graf.valorLocacoes');
        Route::get('grafDespesas', 'ImovelController@grafDespesas')->name('graf.despesas');
        Route::get('empresa/ver/{id}', 'EmpresaController@ver')->name('empresa.ver');
        Route::get('relatErro/criar', 'RelatorioErroController@create')->name('relatErro.criar');
        Route::post('relatErro/salvar', 'RelatorioErroController@store')->name('relatErro.salvar');
    });
});

Auth::routes();
