<?php

use Illuminate\Support\Facades\Route;

// ROTAS DE AUTENTICAÇÃO
// Route::get('/login', 'Auth\LoginController@loginView')->name('loginView');
Route::get('/esqueci-minha-senha', 'Auth\LoginController@resetPasswordView')->name('resetPasswordView');
Route::post('/esqueci-minha-senha', 'Auth\LoginController@resetPassword')->name('resetPassword');
Route::get('/buscar-pin', 'Auth\LoginController@getPin')->name('getPin');
// Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/sair', 'Auth\LoginController@logout')->name('logout');
Route::get('municipe/sair', 'Auth\LoginController@logoutNotServer')->name('logout-municipe');

Route::group(['middleware' => ['custom.auth']], function () {
    Route::get('/', 'ContrachequeController@index')->name('dashboard');

    //Comprovante Despesas Médicas
    Route::get('/consulta/comprovante-despesas-medicas', 'ComprovanteDespesasMedicasController@view')->name('consulta.comprovante-despesas-medicas');
    Route::get('/consulta/comprovante-despesas-medicas/pdf', 'ComprovanteDespesasMedicasController@pdf')->name('comprovante-despesas-medicas.pdf');

    // Dívidas do Segurado
    Route::get('/consulta/dividas-segurado', 'Divida\DividaController@index')->name('view.dividas');
    Route::get('/consulta/dividas-segurado/{id}/relatorio-basico/{status}', 'Divida\DividaController@getBasicReport')->name('dividas.basicReport');

    Route::get('/consulta/atendimentos-nao-inscritos', 'Divida\DividaController@unregisteredDebt')->name('unregisteredDebt');

    Route::group(['middleware' => ['hasContract']], function () {
        Route::get('/consulta/demonstrativo-mensal', 'ContrachequeController@consultaDemonstrativoMensal')->name('consultaDemonstrativoMensal');
        Route::get('/consulta/demonstrativo-periodo', 'ContrachequeController@consultaDemonstrativoPeriodo')->name('consultaDemonstrativoPeriodo');
        Route::post('/consulta/contracheque-mensal', 'ContrachequeController@buscaContrachequeMensal')->name('buscaContrachequeMensal');
        Route::post('geraPdfMensal', 'ContrachequeController@geraPdfMensal')->name('geraPdfMensal');
        Route::post('geraPdfPeriodo', 'ContrachequeController@geraPdfPeriodo')->name('geraPdfPeriodo');

        //CRP
        Route::get('/consulta/comprovante-rendimentos-pagos', 'Divida\DividaController@crpView')->name('consulta.crp');

        Route::get('/consulta/comprovante-rendimentos-pagos/pdf', 'Divida\DividaController@getCrp')->name('crp.pdf');
    });
});


// Busca de dados para o sistema de atendimentos médicos
Route::get('/servicos', 'ApiController@getServices')->name('services');
Route::get('/pessoas', 'ApiController@getPeople')->name('people');
Route::get('/valor-servico', 'ApiController@getServiceValue')->name('service-value');

Route::get('/teste', 'ApiController@teste')->name('teste');


// ROTAS DE AUTENTICAÇÃO
Route::get('/login', 'Autenticacao\LoginController@chamaViewLogin')->name('chamaViewLogin');
Route::post('/login', 'Autenticacao\LoginController@login')->name('login');
Route::get('/logout', 'Autenticacao\LoginController@logout')->name('logout');
