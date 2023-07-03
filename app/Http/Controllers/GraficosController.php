<?php

namespace App\Http\Controllers;

use App\Models\Equipamentos; // Certifique-se de ter a model definido corretamente
use Carbon\Carbon;
use App\Models\Datalog;

class GraficosController extends Controller
{
    public function index()
    {
        $equipamentos = Equipamentos::all();
        $datalog = Datalog::all();

        return view('nav.graficos', compact('equipamentos'))
            ->extends('adminlte::page', ['iFrameEnabled' => true]);
    }
    
}
