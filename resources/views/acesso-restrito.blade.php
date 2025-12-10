@extends('layouts.publico')

@section('title', 'Acesso Restrito')

@section('content')

<style>
/* (mantém o CSS da versão estilizada que fizemos) */
</style>

<div class="restricted-wrapper">

    <div class="restricted-card">

        <div class="restricted-icon">
            <i class="fa-solid fa-shield-halved"></i>
        </div>

        <h1 class="restricted-title">Acesso Restrito</h1>

        <p class="restricted-text">
            Olá, <strong>{{ Auth::user()->nome }}</strong>.<br>
            Você está autenticado, mas não possui permissão para acessar esta área do sistema.
        </p>

        <a href="{{ route('dashboard') }}" class="restricted-btn">
            <i class="fa fa-arrow-left me-1"></i> Voltar ao Início
        </a>

    </div>

</div>

@endsection
