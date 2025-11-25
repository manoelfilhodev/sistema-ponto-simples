<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Sistema Ponto | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS Base -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/css/app-creative.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app-creative-dark.min.css') }}" rel="stylesheet">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(110deg, #1b2a4e 0%, #27467e 40%, #793b99 100%);
            overflow: hidden;
        }

        /* Fade elegante sobre o fundo */
        .fade-layer {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 40%, rgba(255,255,255,0.12), transparent 60%),
                        radial-gradient(circle at 80% 70%, rgba(0,0,0,0.18), transparent 60%);
            pointer-events: none;
        }

        /* Card glass moderno */
        .auth-card {
            width: 100%;
            max-width: 420px;
            padding: 40px 35px;
            border-radius: 18px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.35);
            animation: fadeIn 0.7s ease-out;
            color: #fff;
            z-index: 10;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .auth-logo img {
            max-width: 150px;
        }

        .form-control {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .btn-login {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
            font-weight: 600;
            transition: .25s;
        }

        .btn-login:hover {
            opacity: .9;
            transform: scale(1.02);
        }

        .ssl-info {
            color: #e9e9e9;
            font-size: 12px;
            margin-top: 15px;
        }

        footer {
            color: #ddd;
            font-size: 13px;
            margin-top: 18px;
            text-align: center;
            z-index: 10;
        }
    </style>
</head>

<body>

    <div class="fade-layer"></div>

    <div class="auth-card">
        @yield('content')
    </div>



</body>
</html>
