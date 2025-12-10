@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <h3 class="fw-bold mb-4">Editar Usuário</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nome</label>
                        <input type="text" name="name" value="{{ $usuario->name }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">E-mail</label>
                        <input type="email" name="email" value="{{ $usuario->email }}" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">

                    <div class="col-md-4">
                        <label class="form-label fw-bold">CPF</label>
                        <input type="text" name="cpf" value="{{ $usuario->cpf }}" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nível</label>
                        <select name="cargo" class="form-select">
                            <option value="ADMIN"   {{ $usuario->cargo == 'ADMIN' ? 'selected' : '' }}>Administrador</option>
                            <option value="GESTOR"  {{ $usuario->cargo == 'GESTOR' ? 'selected' : '' }}>Gestor</option>
                            <option value="USUARIO" {{ $usuario->cargo == 'USUARIO' ? 'selected' : '' }}>Usuário</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Senha (opcional)</label>
                        <input type="password" name="password" class="form-control">
                        <small class="text-muted">Preencha apenas se quiser alterar</small>
                    </div>
                </div>

                <button class="btn btn-primary mt-3">
                    <i class="bi bi-check-circle me-1"></i> Salvar Alterações
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
