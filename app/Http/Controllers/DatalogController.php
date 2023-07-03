<?php

namespace App\Http\Controllers;

use App\Models\Datalog; // Certifique-se de ter o modelo definido corretamente
use App\Models\Equipamentos; // Certifique-se de ter o modelo definido corretamente
use App\Models\Logevent;
use Carbon\Carbon;

class DatalogController extends Controller
{
    public function index()
    {
        $data_logs = Datalog::all(); // Obtém todos os equipamentos do banco de dados
        $equipamentos = Equipamentos::all(); // Obtém todos os equipamentos do banco de dados

        return view('nav.datalogs', compact('equipamentos', 'data_logs'))
            ->extends('adminlte::page', ['iFrameEnabled' => true]);
    }

    public function logEvent()
    {
        // Obtém a última entrada de cada equipamento na tabela dados_nobreaks
        $data_logs = Datalog::whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')
                ->from('dados_nobreaks')
                ->groupBy('id_equipamento');
        })->get();

        $equipamentos = Equipamentos::all(); // Obtém todos os equipamentos do banco de dados

        foreach ($data_logs as $data_log) {
            // Verifica se a Battery_voltage está abaixo de 20
            if ($data_log->Battery_voltage < 20) {
                // Grava um log na tabela log_events
                $log = new Logevent;
                $log->equipamento_id = $data_log->id_equipamento;
                $log->data_hora = now(); // Data e hora atual
                $log->log = 'A voltagem da bateria está abaixo de 20%.';
                $log->save();
            } elseif ($data_log->Battery_voltage == 100) {
                // Grava um log informando que a bateria voltou ao normal
                $log = new Logevent;
                $log->equipamento_id = $data_log->id_equipamento;
                $log->data_hora = now(); // Data e hora atual
                $log->log = 'A voltagem da bateria voltou ao normal.';
                $log->save();
            }
        }

        return view('nav.logevents', compact('equipamentos', 'data_logs'))
            ->extends('adminlte::page', ['iFrameEnabled' => true]);
    }

    public function getChartData($idEquipamento)
    {
        $dataLogs = Datalog::where('id_equipamento', $idEquipamento)
            ->orderBy('data_hora')
            ->get(['data_hora', 'Battery_voltage']);

        $chartData = [];

        foreach ($dataLogs as $dataLog) {
            $timestamp = Carbon::parse($dataLog->data_hora)->getTimestamp() * 1000;
            $chartData[] = [$timestamp, $dataLog->Battery_voltage];
        }

        return response()->json($chartData);
    }

}
