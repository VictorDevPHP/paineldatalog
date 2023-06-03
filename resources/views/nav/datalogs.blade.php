@extends('adminlte::page')

<head>
    <link rel="stylesheet" href="/css/table.css">
</head>

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/table.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable();

            $('#equipamento').on('change', function() {
                var equipamentoId = $(this).val();
                table.column(0)
                    .search(equipamentoId ? '^' + equipamentoId + '$' : '', true, false)
                    .draw();
            });
        });
    </script>
@endsection

@section('content')
    <div class="mb-3">
        <label for="equipamento" class="form-label">Filtrar por Equipamento:</label>
        <select class="form-select" id="equipamento" name="equipamento">
            <option value="">Todos os Equipamentos</option>
            @foreach ($equipamentos as $equipamento)
                <option value="{{ $equipamento->id }}">{{ $equipamento->nome }}</option>
            @endforeach
        </select>
    </div>

    <table id="data_logs" class="table table-striped data-table" style="width:100%">
        <thead>
            <tr>
                <th>ID Equipamento</th>
                <th>ID Registro</th>
                <th>Capacidade da Bateria</th>
                <th>Temperatura da Bateria</th>
                <th>Status da Bateria</th>
                <th>Hora do Registro</th>
                <th>Tempo de atividade</th>
                <th>Painel de Configuração</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_logs as $data_log)
                <tr>
                    <td>{{ $data_log->id_equipamento }}</td>
                    <td>{{ $data_log->id }}</td>
                    <td>{{ $data_log->Battery_capacity }}%</td>
                    <td>{{ $data_log->Battery_temperature }}</td>
                    <td>{{ $data_log->Battery_status }}</td>
                    <td>{{ date('d/m/Y H:i:s', strtotime($data_log->data_hora)) }}</td>
                    <td>
                        {{
                            gmdate('d', $data_log->Uptime) . ' dias, ' .
                            gmdate('H', $data_log->Uptime) . ' horas, ' .
                            gmdate('i', $data_log->Uptime) . ' minutos'
                        }}
                    </td>
                    <td class="acoes">
                        <a href="{{ $data_log->ip }}" title="Configuração do data_log" alt="Configuração do equipamento"
                            class="btn">
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
