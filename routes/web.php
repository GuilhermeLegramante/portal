<?php

use Illuminate\Support\Facades\Route;

Route::get('/login-novo', 'Autenticacao\LoginController@loginView')->name('loginView');
Route::get('/esqueci-minha-senha', 'Autenticacao\LoginController@resetPasswordView')->name('resetPasswordView');



// ROTA PARA CONFIGURAÇÃO DO BANCO
Route::get('/config/{serverName}/{dbName}', 'ConfigController@index')->name('index');

// ROTAS DE AUTENTICAÇÃO
Route::get('/login', 'Autenticacao\LoginController@chamaViewLogin')->name('chamaViewLogin');
Route::post('/login', 'Autenticacao\LoginController@login')->name('login');
Route::get('/logout', 'Autenticacao\LoginController@logout')->name('logout');

Route::group(['middleware' => ['autenticacao']], function () {
    Route::get('/', 'Autenticacao\LoginController@chamaViewPortal')->name('portal');
    Route::post('/edicaoDadosUsuario', 'Usuario\UsuarioController@edicaoDadosUsuario')->name('edicaoDadosUsuario');
});

// ROTAS PARA TESTES DE ENVIO DE E-MAILS
Route::get('/teste', function () {
    dd(asset('vendor/fontawesome-free/css/all.min.css'));
});

Route::get('/login-teste', 'Autenticacao\LoginController@loginTeste')->name('loginTeste');
