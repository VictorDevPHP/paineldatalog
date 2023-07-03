<?php

namespace App\Http\Controllers;

use App\Models\Equipamentos; // Certifique-se de ter a model definido corretamente

class VisaoGeralController extends Controller
{
    public function index()
    {   
        $equipamentos = Equipamentos::all(); // Obtém todos os equipamentos do banco de dados
        $totalEquipamentos = Equipamentos::count();
        $naoComunicantes = Equipamentos::where('status', 'Não comunicando')->count();

        return view('nav.visaogeral', compact('totalEquipamentos', 'naoComunicantes', 'equipamentos'))
            ->extends('adminlte::page', ['iFrameEnabled' => true]);
    }

}
