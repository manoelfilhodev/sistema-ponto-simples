@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <h3 class="text-dark fw-bold m-0">Usuários Cadastrados</h3>

        <div class="d-flex gap-2">

            {{-- Excluir selecionados --}}
            <form id="formExcluirSelecionados" action="{{ route('usuarios.destroy.multiple') }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
                <input type="hidden" id="idsSelecionados" name="ids">
            </form>

            <button id="btnExcluirSelecionados"
                class="btn btn-danger shadow-sm d-flex align-items-center px-3"
                disabled>
                <i class="bi bi-trash3 me-2"></i>
                Excluir Selecionados
            </button>

            {{-- Novo usuário --}}
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center px-3">
                <i class="bi bi-plus-circle me-2"></i>
                Novo Usuário
            </a>
        </div>
    </div>

    {{-- Notificação --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill fs-5 me-2"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- TABELA --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="40" class="text-center">
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>Nível</th>
                        <th>Cadastrado em</th>
                        <th width="120" class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($usuarios as $u)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="checkboxUser form-check-input" value="{{ $u->id }}">
                            </td>

                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->cpf }}</td>

                            <td>
                                <span class="badge
                                    @if($u->nivel === 'ADMIN') bg-danger
                                    @elseif($u->cargo === 'GESTOR') bg-warning text-dark
                                    @else bg-secondary
                                    @endif
                                ">
                                    {{ $u->cargo }}
                                </span>
                            </td>

                            <td>{{ $u->created_at->format('d/m/Y') }}</td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-2">

                                    {{-- Editar --}}
                                    <a href="{{ route('usuarios.edit', $u->id) }}"
                                        class="btn btn-warning btn-sm text-white rounded-circle"
                                        data-bs-toggle="tooltip" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Excluir --}}
                                    <form action="{{ route('usuarios.destroy', $u->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Deseja excluir este usuário?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm rounded-circle"
                                            data-bs-toggle="tooltip" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">
                                Nenhum usuário encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.checkboxUser');
    const btnExcluir = document.getElementById('btnExcluirSelecionados');
    const idsSelecionadosInput = document.getElementById('idsSelecionados');

    // Selecionar todos
    selectAll.addEventListener('change', function () {
        checkboxes.forEach(c => c.checked = selectAll.checked);
        atualizarBotao();
    });

    // Atualiza botão
    checkboxes.forEach(c => c.addEventListener('change', atualizarBotao));

    function atualizarBotao() {
        const selecionados = [...checkboxes].filter(c => c.checked).length;
        btnExcluir.disabled = selecionados === 0;
    }

    // Excluir selecionados
    btnExcluir.addEventListener('click', function () {
        const ids = [...checkboxes]
            .filter(c => c.checked)
            .map(c => c.value);

        if (ids.length === 0) return;

        if (!confirm(`Deseja excluir ${ids.length} usuário(s)?`)) return;

        idsSelecionadosInput.value = JSON.stringify(ids);
        document.getElementById('formExcluirSelecionados').submit();
    });
</script>
@endsection
