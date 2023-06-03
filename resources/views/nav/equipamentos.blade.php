@extends('adminlte::page')
<!-- Substitua 'layout.app' pelo nome do seu layout principal -->

<head>
    <link rel="stylesheet" href="/css/table.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
</head>
@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/table.js') }}"></script>
@endsection
@section('content')
    <!-- Modal Novo Equipamento -->
    <div class="modal fade" id="novo-equipamento-modal" tabindex="-1" role="dialog"
        aria-labelledby="novo-equipamento-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="novo-equipamento-modal-label">Novo Equipamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de cadastro do novo equipamento -->
                    <form action="{{ route('equipamentos.store') }}" method="POST">
                        @csrf
                        <div class="form-group"><i class="fad fa-plug"></i>

                            <label for="nome">Nome do Equipamento</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="ip">IP</label>
                            <input type="text" class="form-control" id="ip" name="ip" required>
                        </div>
                        <div class="form-group">
                            <label for="versao_protocolo">Versão do Protocolo</label>
                            <input type="text" class="form-control" id="versao_protocolo" name="versao_protocolo"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="versao_protocolo">Porta</label>
                            <input type="text" class="form-control" id="porta" name="porta" required>
                        </div>
                        <div class="form-group">
                            <label for="versao_protocolo">Comunidade SNMP</label>
                            <input type="text" class="form-control" id="comunidade_snmp" name="comunidade_snmp" required>
                        </div>
                        <div class="form-group">
                            <label for="versao_protocolo">Usuario SNMP</label>
                            <input type="text" class="form-control" id="usuario_snmp" name="usuario_snmp" required>
                        </div>
                        <div class="form-group">
                            <label for="versao_protocolo">Senha SNMP</label>
                            <input type="text" class="form-control" id="senha_snmp" name="senha_snmp" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-success toastrDefaultSuccess">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <table id="equipamentos" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Equipamento</th>
                <th>IP</th>
                <th>Versão do Protocolo</th>
                <th>Status</th>
                <th>Painnel de configuração</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipamentos as $equipamento)
            <tr>
                <td>{{ $equipamento->id }}</td>
                <td>{{ $equipamento->nome }}</td>
                <td>{{ $equipamento->ip }}</td>
                <td>{{ $equipamento->versao_protocolo }}</td>
                <td class="@if ($equipamento->status === 'Comunicando') text-success @elseif ($equipamento->status === 'Não comunicando') text-danger @endif">
                    {{ $equipamento->status }}
                </td>
                <td class="acoes">
                    <a href="{{ $equipamento->ip }}" title="Configuração do equipamento" alt="Configuração do eqipamento" class="btn">
                        <i class="far fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mb-3">
        <a href="#" class="btn btn-primary" id="novo-equipamento-btn" data-toggle="modal"
            data-target="#novo-equipamento-modal">
            Novo Equipamento
        </a>
    </div>
@endsection
