<div class="page-title-box">
    <div class="page-title">
        {{ $titulo ?? 'Página' }}
    </div>

    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="{{ route('painel.index') }}">Início</a></li>
        <li class="breadcrumb-item active">{{ $titulo ?? '' }}</li>
    </ol>
</div>
