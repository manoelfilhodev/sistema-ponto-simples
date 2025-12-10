<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Acesso ao Ponto</title>

    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            min-height: 100vh;
        }

        .card-custom {
            border-radius: 12px;
        }

        small.lgpd-text {
            font-size: 0.75rem;
            color: #6c757d;
            display: block;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card card-custom shadow p-4 bg-white" style="max-width: 420px; width: 100%;">

        <h4 class="text-center mb-2 fw-bold text-dark">Acesso ao Sistema de Ponto</h4>

        <p class="text-center text-muted mb-4" style="font-size: 0.9rem;">
            Para registrar sua jornada, informe seu CPF abaixo.
            Essa etapa garante sua identificação de forma segura
            antes de realizar o registro do ponto.
        </p>

        @if(session('erro'))
            <div class="alert alert-danger text-center">{{ session('erro') }}</div>
        @endif

        <form method="POST" action="{{ route('ponto.validarCpf') }}">
            @csrf

            <label class="form-label fw-semibold">Digite seu CPF</label>
            <input type="text" name="cpf" class="form-control" placeholder="Apenas números" required>

            <button type="submit" class="btn btn-primary w-100 mt-3 py-2 fw-semibold">
                Continuar
            </button>
        </form>

        <small class="lgpd-text">
            Este sistema segue as diretrizes da <strong>Lei Geral de Proteção de Dados (LGPD)</strong>.
            Suas informações são utilizadas exclusivamente para fins de identificação e registro de ponto.
        </small>

    </div>
</div>

</body>
</html>
