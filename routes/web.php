<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Publico\PontoController;
use App\Http\Controllers\Publico\FaceController;
use App\Http\Controllers\Painel\DashboardController;
use App\Http\Controllers\Painel\UsuarioController;
use App\Http\Controllers\Painel\ClienteController;
use App\Http\Controllers\Painel\RegistroPontoController;
use App\Http\Controllers\Painel\RelatorioController;
use App\Http\Controllers\Painel\ConfiguracaoController;

// ---------- PÚBLICO (sem login) ----------
Route::get('/', function () {
    return redirect()->route('login');
});


Route::prefix('ponto')->group(function () {
    Route::get('/bater/facial', [PontoController::class, 'baterFacial'])->name('ponto.bater.facial');
    Route::post('/bater/facial', [PontoController::class, 'registrarFacial'])->name('ponto.registrar.facial');

    Route::get('/bater/cpf', [PontoController::class, 'baterCpf'])->name('ponto.bater.cpf');
    Route::post('/bater/cpf', [PontoController::class, 'registrarCpf'])->name('ponto.registrar.cpf');

    // fluxo de cadastro de face via CPF
    Route::get('/atribuir-foto', [FaceController::class, 'formAtribuirFoto'])->name('ponto.atribuir.foto');
    Route::post('/atribuir-foto', [FaceController::class, 'salvarFoto'])->name('ponto.salvar.foto');

    Route::get('/sucesso', [PontoController::class, 'sucesso'])->name('ponto.sucesso');
});

// ---------- AUTENTICAÇÃO PAINEL ----------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// ---------- PAINEL (ADMIN / GESTÃO) ----------
Route::prefix('painel')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('painel.dashboard');

    // Usuários / Colaboradores
    Route::resource('usuarios', UsuarioController::class);

    // Clientes (empresas onde o ponto será usado)
    Route::resource('clientes', ClienteController::class);

    // Registros de Ponto
    Route::get('registros', [RegistroPontoController::class, 'index'])->name('painel.registros.index');
    Route::get('registros/{registro}', [RegistroPontoController::class, 'show'])->name('painel.registros.show');

    // Relatórios
    Route::get('relatorios', [RelatorioController::class, 'index'])->name('painel.relatorios.index');
    Route::get('relatorios/exportar', [RelatorioController::class, 'exportar'])->name('painel.relatorios.exportar');

    // Configurações gerais (limites, horários, etc)
    Route::get('configuracoes', [ConfiguracaoController::class, 'index'])->name('painel.config.index');
    Route::post('configuracoes', [ConfiguracaoController::class, 'salvar'])->name('painel.config.salvar');
});
