@extends('layouts.app')

@section('page-heading')
<h3 class="fw-bold">Registros de Ponto</h3>
@endsection

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body">

        {{-- ================= FILTROS ================= --}}
        <form method="GET" class="row g-3 mb-4">

            <div class="col-md-3">
                <label class="form-label fw-semibold">Usuário</label>
                <select name="usuario_id" class="form-select shadow-sm">
                    <option value="">Todos</option>
                    @foreach ($usuarios as $u)
                        <option value="{{ $u->id }}" {{ request('usuario_id') == $u->id ? 'selected' : '' }}>
                            {{ $u->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Tipo</label>
                <select name="tipo" class="form-select shadow-sm">
                    <option value="">Todos</option>
                    <option value="entrada">Entrada</option>
                    <option value="intervalo">Intervalo</option>
                    <option value="retorno">Retorno</option>
                    <option value="saida">Saída</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Data Início</label>
                <input type="date" name="data_inicio" class="form-control shadow-sm" value="{{ request('data_inicio') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Data Fim</label>
                <input type="date" name="data_fim" class="form-control shadow-sm" value="{{ request('data_fim') }}">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100 shadow-sm">
                    <i class="bi bi-search"></i> Filtrar
                </button>
            </div>

        </form>

        {{-- ================= TABELA ================= --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:70px">Foto</th>
                        <th>Usuário</th>
                        <th>Tipo</th>
                        <th>Data/Hora</th>
                        <th>Local</th>
                        <th style="width:50px">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($registros as $r)
                        <tr>

                            {{-- FOTO --}}
                            <td>
                                <img src="{{ asset('storage/' . $r->foto) }}" 
                                     class="rounded shadow-sm"
                                     width="55" height="55" style="object-fit: cover;">
                            </td>

                            {{-- USUÁRIO --}}
                            <td class="fw-semibold">{{ $r->user->name }}</td>

                            {{-- TIPO --}}
                            <td>
                                <span class="badge 
                                @if($r->tipo == 'entrada') bg-success 
                                @elseif($r->tipo == 'intervalo') bg-warning 
                                @elseif($r->tipo == 'retorno') bg-info 
                                @else bg-danger @endif">
                                    {{ ucfirst($r->tipo) }}
                                </span>
                            </td>

                            {{-- DATA/HORA --}}
                            <td>{{ \Carbon\Carbon::parse($r->data_hora)->format('d/m/Y H:i') }}</td>

                            {{-- LOCAL DO REGISTRO --}}
                            <td>
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>

                                @if($r->localidade)
                                    <span class="text-muted" data-bs-toggle="tooltip" title="{{ $r->localidade }}">
                                        {{ Str::limit($r->localidade, 28) }}
                                    </span>
                                @else
                                    <span class="text-muted fst-italic">Não informado</span>
                                @endif
                            </td>

                            {{-- AÇÃO --}}
                            <td>
                                <a href="{{ route('registros.show', $r->id) }}" 
                                   class="btn btn-sm btn-outline-primary shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        {{-- PAGINAÇÃO --}}
        <div class="mt-3">
            {{ $registros->links() }}
        </div>

    </div>
</div>

{{-- ATIVAR TOOLTIP --}}
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el);
    });
</script>

@endsection
