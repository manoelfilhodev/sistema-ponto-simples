<?php

use Illuminate\Support\Facades\Route;

// ---------- Controllers ----------
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

// === ACESSO PÚBLICO PARA REGISTRO DE PONTO === //
Route::get('/acesso', [PontoController::class, 'acessoPublico'])->name('ponto.acesso');
Route::post('/acesso', [PontoController::class, 'validarCpf'])->name('ponto.validarCpf');

// Tela de bater ponto (pública)
Route::get('/bater-ponto/{user}', [PontoController::class, 'telaBaterPonto'])->name('ponto.tela');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/bater-ponto/{userId}', [PontoController::class, 'registrarPontoPublico'])
    ->name('ponto.registrarPublico');



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


// ---------- ACESSO RESTRITO ----------
Route::get('/acesso-restrito', function () {
    return view('painel.erro-acesso');
})->name('acesso.restrito');


// ---------- PAINEL ADMIN / GESTÃO ----------
Route::prefix('painel')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('painel.dashboard');

    // ============================================================
    // USUÁRIOS (CRUD COMPLETO)
    // ============================================================
    Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

    Route::get('usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // NOVA ROTA — Exclusão em massa
    Route::delete('usuarios/delete/multiple', [UsuarioController::class, 'destroyMultiple'])
        ->name('usuarios.destroy.multiple');
    // ============================================================
    // CLIENTES
    // ============================================================
    Route::resource('clientes', ClienteController::class);


    // ============================================================
    // REGISTROS DE PONTO
    // ============================================================
    Route::get('registros', [RegistroPontoController::class, 'index'])
        ->name('registros.index');

    Route::get('registros/{registro}', [RegistroPontoController::class, 'show'])
        ->name('registros.show');



    // ============================================================
    // RELATÓRIOS
    // ============================================================
    Route::get('relatorios', [RelatorioController::class, 'index'])->name('painel.relatorios.index');
    Route::get('relatorios/exportar', [RelatorioController::class, 'exportar'])->name('painel.relatorios.exportar');


    // ============================================================
    // CONFIGURAÇÕES
    // ============================================================
    Route::get('configuracoes', [ConfiguracaoController::class, 'index'])->name('painel.config.index');
    Route::post('configuracoes', [ConfiguracaoController::class, 'salvar'])->name('painel.config.salvar');
});
