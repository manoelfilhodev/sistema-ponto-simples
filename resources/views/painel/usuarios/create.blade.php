@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark fw-bold">Cadastrar Usuário</h3>
    </div>

    {{-- ALERTAS DE ERRO --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <h6 class="fw-bold mb-2">
                <i class="bi bi-exclamation-circle me-1"></i> Atenção!
            </h6>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf

                {{-- TÍTULO --}}
                <h5 class="fw-bold text-secondary mb-3">Informações do Usuário</h5>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nome completo</label>
                        <input type="text" name="name" class="form-control form-control-lg"
                               placeholder="Ex.: João da Silva" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">E-mail</label>
                        <input type="email" name="email" class="form-control form-control-lg"
                               placeholder="email@empresa.com" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">CPF</label>
                        <input type="text" id="cpf" name="cpf"
                               class="form-control form-control-lg"
                               placeholder="000.000.000-00" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nível de Acesso</label>
                        <select name="cargo" class="form-select form-select-lg" required>
                            <option value="">Selecione...</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Gestor">Gestor</option>
                            <option value="Usuário">Usuário</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Senha (gerada automaticamente pelo CPF)
                        </label>

                        <div class="input-group">
                            <input type="password" name="password" id="senha"
                                   class="form-control form-control-lg"
                                   readonly>

                            <span class="input-group-text" onclick="toggleSenha()" style="cursor:pointer;">
                                <i class="bi bi-eye-slash" id="toggle-icon"></i>
                            </span>
                        </div>
                    </div>

                </div>

                <button class="btn btn-primary btn-lg mt-4 px-4">
                    <i class="bi bi-check-circle me-1"></i> Salvar Usuário
                </button>

            </form>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // === CPF COM MÁSCARA + SENHA GERADA AUTOMATICAMENTE ===
    document.getElementById('cpf').addEventListener('input', function () {
        // remove tudo que não for número
        let v = this.value.replace(/\D/g, "");

        // aplica a máscara visual
        let mask = v.replace(/(\d{3})(\d)/, "$1.$2");
        mask = mask.replace(/(\d{3})(\d)/, "$1.$2");
        mask = mask.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        this.value = mask;

        // senha = cpf sem máscara
        document.getElementById("senha").value = v;
    });

    // === MOSTRAR / OCULTAR SENHA ===
    function toggleSenha() {
        const senha = document.getElementById("senha");
        const icon = document.getElementById("toggle-icon");

        if (senha.type === "password") {
            senha.type = "text";
            icon.classList.replace("bi-eye-slash", "bi-eye");
        } else {
            senha.type = "password";
            icon.classList.replace("bi-eye", "bi-eye-slash");
        }
    }
</script>
@endsection
