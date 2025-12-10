<header class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand fw-bold" href="{{ route('painel.dashboard') }}">
        <i class="fa fa-clock me-2"></i> Systex Ponto
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topmenu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="topmenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('painel.dashboard') }}">
                    <i class="fa fa-home me-1"></i> Início
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('usuarios.index') }}">
                    <i class="fa fa-users me-1"></i> Usuários
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('registros.index') }}">
                    <i class="fa fa-list me-1"></i> Registros
                </a>
            </li>

        </ul>

        <ul class="navbar-nav mb-2 mb-lg-0">

            <li class="nav-item me-3">
                <button onclick="toggleDarkMode()" class="btn btn-outline-light btn-sm">
                    <i class="fa fa-moon"></i>
                </button>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle fw-bold" data-bs-toggle="dropdown" href="#">
                    {{ Auth::user()->nome }}
                </a>
                <div class="dropdown-menu dropdown-menu-end">

                    <a href="#" class="dropdown-item">
                        <i class="fa fa-user me-1"></i> Meu Perfil
                    </a>

                    <a href="{{ route('logout') }}" class="dropdown-item text-danger"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off me-1"></i> Sair
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>

                </div>
            </li>

        </ul>
    </div>
</header>
