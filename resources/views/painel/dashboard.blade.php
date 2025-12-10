@extends('layouts.app')

@section('page-heading')
    <h3 class="fw-bold">Painel de Controle</h3>
@endsection

@section('content')

{{-- CARDS RESUMO --}}
<section class="row mb-4">

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card card-statistic shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted mb-1">Batidas Hoje</h6>
                <h3 class="fw-bold">{{ $batidasHoje }}</h3>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card card-statistic shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted mb-1">Usuários Ativos</h6>
                <h3 class="fw-bold">{{ $usuariosAtivos }}</h3>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card card-statistic shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted mb-1">Registros no Mês</h6>
                <h3 class="fw-bold">{{ $registrosMes }}</h3>
            </div>
        </div>
    </div>

</section>

{{-- BOTÃO SAIR --}}
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button class="btn btn-danger px-4">Sair do Sistema</button>
</form>

@endsection
