<?php

namespace App\Http\Controllers;

use App\Models\Datalog; // Certifique-se de ter o modelo definido corretamente
use App\Models\Equipamentos; // Certifique-se de ter o modelo definido corretamente
use Illuminate\Http\Request;

class PainelconfController extends Controller
{
    public function index()
    {
        return view('nav.painelconf')
        ->extends('adminlte::page', ['iFrameEnabled' => true]);
    }
}
