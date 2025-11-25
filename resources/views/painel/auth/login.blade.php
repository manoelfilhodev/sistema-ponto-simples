@extends('layouts.auth')

@section('content')

<div class="text-center mb-4">
    <img src="{{ asset('images/logo-sem-nome.png') }}" alt="Logo" class="mb-3" height="120">
    <h4 class="fw-bold">Sistema Ponto</h4>
    <p class="small" style="color: rgba(255,255,255,0.8);">
        Informe suas credenciais para continuar.
    </p>
</div>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
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

     <footer>
        © {{ date('Y') }} Systex Sistemas Inteligentes<br>

    </footer>
</form>



@endsection
