<div class="leftside-menu">

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <a href="{{ route('painel.dashboard') }}" class="logo text-center mt-3">
            <span class="logo-lg fw-bold text-white">
                <i class="fa fa-clock me-1"></i> Systex Ponto
            </span>
        </a>

        <ul class="side-nav mt-4">

            <li class="side-nav-item">
                <a href="{{ route('painel.dashboard') }}" class="side-nav-link">
                    <i class="fa fa-home"></i>
                    <span> Início </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('usuarios.index') }}" class="side-nav-link">
                    <i class="fa fa-users"></i>
                    <span> Usuários </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('registros.index') }}" class="side-nav-link">
                    <i class="fa fa-list"></i>
                    <span> Registros de Ponto </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('painel.relatorios.index') }}" class="side-nav-link">
                    <i class="fa fa-file-alt"></i>
                    <span> Relatórios </span>
                </a>
            </li>

        </ul>

        <div class="clearfix"></div>

    </div>
</div>
