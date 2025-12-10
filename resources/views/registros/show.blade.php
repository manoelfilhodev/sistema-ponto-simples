@extends('layouts.app')

@section('page-heading')
    <h3 class="fw-bold">Detalhes do Registro</h3>
@endsection

@section('content')
       <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row">

                <div class="col-md-5 text-center">
                    <img src="{{ asset('storage/' . $registro->foto) }}" class="rounded shadow" width="260">
                </div>

                <div class="col-md-7">

                    <h4 class="fw-bold">{{ $registro->user->name }}</h4>
                    <p class="text-muted mb-2">{{ $registro->user->cpf }}</p>

                    <p>
                        <strong>Tipo:</strong>
                        <span
                            class="badge 
                        @if ($registro->tipo == 'entrada') bg-success
                        @elseif($registro->tipo == 'intervalo') bg-warning
                        @elseif($registro->tipo == 'retorno') bg-info
                        @else bg-danger @endif">
                            {{ ucfirst($registro->tipo) }}
                        </span>
                    </p>

                    <p><strong>Data/Hora:</strong> {{ \Carbon\Carbon::parse($registro->data_hora)->format('d/m/Y H:i:s') }}
                    </p>

                    @if ($registro->latitude && $registro->longitude)
                        <p><strong>Localização:</strong> {{ $registro->latitude }}, {{ $registro->longitude }}</p>

                        <a href="https://maps.google.com/?q={{ $registro->latitude }},{{ $registro->longitude }}"
                            class="btn btn-outline-primary btn-sm" target="_blank">
                            <i class="bi bi-geo-alt"></i> Ver no Maps
                        </a>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('registros.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection
