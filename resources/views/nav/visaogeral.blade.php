@extends('adminlte::page')
<!-- Substitua 'layout.app' pelo nome do seu layout principal -->

<head>
    <link rel="stylesheet" href="/css/table.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/table.js') }}"></script>
@endsection

<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalEquipamentos }}</h3>
                <p>Total Equipamentos</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="/nav/equipamentos" class="small-box-footer">Mais informações <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
        <!-- more small boxes... -->
</div>