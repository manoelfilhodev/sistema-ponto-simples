@extends('layouts.auth')

@section('content')

<div class="text-center mb-4">
    <img src="{{ asset('images/logo-sem-nome.png') }}" alt="Logo" class="mb-3" height="120">
    <h4 class="fw-bold">Sistema Ponto</h4>
    <p class="small" style="color: rgba(255,255,255,0.8);">
        Informe suas credenciais para continuar.
    </p>
</div>

{{-- ============================== --}}
{{-- ALERTAS DE ERRO / SUCESSO --}}
{{-- ============================== --}}

@if (session('error'))
    <div class="alert alert-danger d-flex align-items-center shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success d-flex align-items-center shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label text-white">Usuário</label>
        <input type="text" name="email" value="{{ old('email') }}"
               class="form-control" placeholder="Digite seu usuário" required>
    </div>

    <div class="mb-3">
        <label class="form-label text-white">Senha</label>
        <input type="password" name="password"
               class="form-control" placeholder="Digite sua senha" required>
    </div>

    <button class="btn btn-login w-100 mt-3"><b>Entrar</b></button>

    <footer class="mt-4 text-center text-white-50">
        © {{ date('Y') }} Systex Sistemas Inteligentes
    </footer>
</form>

@endsection
