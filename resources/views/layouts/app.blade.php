@php
    $segments = Request::segments();
    $title = ucfirst(end($segments));
@endphp

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', $title) | Systex Ponto</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema de Ponto com Reconhecimento Facial" name="description" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- CSS do template -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" disabled />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* Remoções de elementos originais */
        .content::before,
        .content>svg,
        .sidebar-toggle,
        .vertical-menu-toggle,
        .menu-toggle {
            display: none !important;
        }

        /* Topo operador */
        .top-bar-operador {
            background-color: #111827;
            padding: .75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar-operador span {
            color: #fff;
            font-weight: bold;
        }

        /* Cards Dashboard */
        .card-statistic {
            border-radius: 14px;
            transition: .2s;
        }

        .dark .card-statistic {
            background: #2c2f35 !important;
            color: #ffffff !important;
        }

        .light .card-statistic {
            background: #ffffff !important;
            color: #333333 !important;
        }

        .card-statistic:hover {
            transform: translateY(-2px);
        }
    </style>

    @yield('head')
</head>

<body class="loading" data-layout-config='{"darkMode": false}'>

    <div class="wrapper">

        {{-- SIDEBAR --}}
        @auth
            @if (!in_array(Auth::user()->tipo, ['operador']))
                @include('partials.sidebar')
            @endif
        @endauth

        <div class="content-page">
            <div class="content">

                {{-- HEADER --}}
                @auth
                    @if (!in_array(Auth::user()->tipo, ['operador']))
                        @include('partials.header')
                    @else
                        <div class="top-bar-operador">
                            <span>Systex Ponto</span>
                            <a href="{{ route('ponto.inicio') }}" class="btn btn-outline-light btn-sm">
                                <i class="fa fa-arrow-left me-1"></i> Voltar
                            </a>
                        </div>
                    @endif
                @endauth

                {{-- 🔥 ESTA DIV É FUNDAMENTAL (igual ao WMS) --}}
                <div class="page-heading">
                    @yield('page-heading')
                </div>

                <div class="page-content">
                    @yield('content')
                </div>

            </div>

            @include('partials.footer')
        </div>

    </div>

    <!-- JS Base -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    <script>
        // Aplicar tema salvo
        document.addEventListener("DOMContentLoaded", function() {
            const darkMode = localStorage.getItem("darkMode") === "true";

            document.getElementById("light-style").disabled = darkMode;
            document.getElementById("dark-style").disabled = !darkMode;

            document.documentElement.setAttribute(
                "data-layout-config",
                JSON.stringify({
                    darkMode
                })
            );
        });

        // Alternar tema
        function toggleDarkMode() {
            const darkMode = !(localStorage.getItem("darkMode") === "true");
            localStorage.setItem("darkMode", darkMode);

            document.getElementById("light-style").disabled = darkMode;
            document.getElementById("dark-style").disabled = !darkMode;

            document.documentElement.setAttribute(
                "data-layout-config",
                JSON.stringify({
                    darkMode
                })
            );
        }
    </script>

    <!-- PWA -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js');
            });
        }
    </script>

    @yield('scripts')
    @stack('scripts')

</body>

</html>
