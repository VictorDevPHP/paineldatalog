@extends('adminlte::page')
<!-- Substitua 'layout.app' pelo nome do seu layout principal -->
<head>
    <link rel="stylesheet" href="/css/table.css">
</head>

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/table.js') }}"></script>
    <script>
        function filtrarLogs() {
            var equipamentoId = $('#selectEquipamento').val();

            if (equipamentoId) {
                $('#log_events tbody tr').hide();
                $('#log_events tbody tr[data-equipamento="' + equipamentoId + '"]').show();
            } else {
                $('#log_events tbody tr').show();
            }
        }
    </script>
@endsection
@section('content')
    <div class="mb-3">
        <label for="selectEquipamento" class="form-label">Filtrar por Equipamento:</label>
        <select class="form-select" id="selectEquipamento" onchange="filtrarLogs()">
            <option value="">Todos os Equipamentos</option>
            @foreach ($equipamentos as $equipamento)
                <option value="{{ $equipamento->id }}">{{ $equipamento->nome }}</option>
            @endforeach
        </select>
    </div>

    <table id="log_events" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ID Equipamento</th>
                <th>Data/Hora do Log</th>
                <th>Log</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($log_events as $log_event)
                <tr data-equipamento="{{ $log_event->id_equipamento }}">
                    <td>{{ $log_event->id_equipamento }}</td>
                    <td>{{ date('d/m/Y H:i:s', strtotime($log_event->data_cadastro)) }}</td>
                    <td>{{ $log_event->log }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
