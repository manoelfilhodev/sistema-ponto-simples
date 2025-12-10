<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Acesso Restrito • Systex Ponto</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- CSS base -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" disabled>

    <style>

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #0f172a;
            color: #fff;
            font-family: 'Inter', sans-serif;
        }

        .restricted-card {
            background: #1e293b;
            padding: 50px 60px;
            border-radius: 14px;
            text-align: center;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 28px rgba(0,0,0,0.35);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .restricted-icon {
            font-size: 4.3rem;
            color: #a855f7;
            margin-bottom: 25px;
        }

        .restricted-title {
            font-size: 2.1rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .restricted-text {
            font-size: 1.1rem;
            color: #cbd5e1;
            margin-bottom: 30px;
        }

        .restricted-btn {
            display: inline-block;
            background: linear-gradient(45deg, #8b5cf6, #6366f1);
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            transition: .2s ease;
            box-shadow: 0 4px 12px rgba(99,102,241,.4);
        }

        .restricted-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 14px rgba(99,102,241,.6);
        }

        /* Modo claro automático */
        @media (prefers-color-scheme: light) {
            body {
                background: #f1f5f9;
                color: #0f172a;
            }

            .restricted-card {
                background: #ffffff;
                color: #0f172a;
                border: 1px solid #e2e8f0;
            }

            .restricted-text {
                color: #475569;
            }
        }
    </style>
</head>

<body>

    <div class="restricted-card">

        <div class="restricted-icon">
            <i class="fa-solid fa-shield-halved"></i>
        </div>

        <h1 class="restricted-title">Acesso Restrito</h1>

        <p class="restricted-text">
            Olá, <strong>{{ Auth::user()->name }}</strong>.<br>
            Você está autenticado, mas não possui permissão para acessar esta área.
        </p>

        <a href="{{ route('login') }}" class="restricted-btn">
            <i class="fa fa-arrow-left me-1"></i> Voltar
        </a>

    </div>

</body>
</html>
