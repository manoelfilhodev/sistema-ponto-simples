<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PontoApiController;

Route::prefix('v1')->group(function () {
    // Auth do app (se precisar)
    Route::post('/login', [AuthApiController::class, 'login']);
    Route::post('/logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');

    // Ponto via app (cpf + foto + geo)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/ponto/registrar', [PontoApiController::class, 'registrar']); // recebe cpf, foto, lat, lng, tipo (entrada/saida)
        Route::get('/ponto/ultimos', [PontoApiController::class, 'ultimos']);      // últimos registros do usuário
    });
});
