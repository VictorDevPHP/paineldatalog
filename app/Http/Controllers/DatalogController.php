<?php

namespace App\Http\Controllers;

use App\Models\Datalog; // Certifique-se de ter o modelo definido corretamente
use App\Models\Equipamentos; // Certifique-se de ter o modelo definido corretamente
use Illuminate\Http\Request;

class DatalogController extends Controller
{
    public function index()
    {
        $data_logs = Datalog::all(); // Obtém todos os equipamentos do banco de dados
        $equipamentos = Equipamentos::all(); // Obtém todos os equipamentos do banco de dados

        return view('nav.datalogs', compact('equipamentos', 'data_logs'))
        ->extends('adminlte::page', ['iFrameEnabled' => true]);
    }
}
