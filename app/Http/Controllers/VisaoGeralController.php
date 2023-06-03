<?php

namespace App\Http\Controllers;

use App\Models\Equipamentos; // Certifique-se de ter o modelo definido corretamente
use App\Models\Logevent; // Certifique-se de ter o modelo definido corretamente

class VisaoGeralController extends Controller
{
    public function index()
{
    $totalEquipamentos = Equipamentos::count();

    return view('nav.visaogeral', compact('totalEquipamentos'))
        ->extends('adminlte::page', ['iFrameEnabled' => true]);
}

}
