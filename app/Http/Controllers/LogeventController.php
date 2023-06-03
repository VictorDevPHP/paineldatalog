<?php

namespace App\Http\Controllers;

use App\Models\Logevent; // Certifique-se de ter o modelo definido corretamente
use App\Models\Equipamentos; // Certifique-se de ter o modelo definido corretamente
use Illuminate\Http\Request;

class LogeventController extends Controller
{
    public function index()
    {
        $equipamentos = Equipamentos::all(); // Obtém todos os equipamentos do banco de dados
        $log_events = Logevent::all(); // Obtém todos os logs de eventos do banco de dados
    
        return view('nav.logevents', compact('equipamentos', 'log_events'))
            ->extends('adminlte::page', ['iFrameEnabled' => true]);
    }
}
