<?php

namespace App\Http\Controllers;

use App\Models\Equipamentos;
use Illuminate\Http\Request;

class EquipamentoController extends Controller
{

    public function index()
    {

        $equipamentos = Equipamentos::all();

        return view('nav.equipamentos', compact('equipamentos'))
            ->extends('adminlte::page', ['iFrameEnabled' => true]);
    }

    public function store(Request $request)
    {
        // Valide e salve os dados do novo equipamento no banco de dados
        $equipamento = new Equipamentos;
        $equipamento->nome = $request->input('nome');
        $equipamento->ip = $request->input('ip');
        $equipamento->versao_protocolo = $request->input('versao_protocolo');
        $equipamento->porta = $request->input('porta');
        $equipamento->comunidade_snmp = $request->input('comunidade_snmp');
        $equipamento->usuario_snmp = $request->input('usuario_snmp');
        $equipamento->senha_snmp = $request->input('senha_snmp');
        $equipamento->save();

        // Redirecione com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Equipamento cadastrado com sucesso!');
    }

}
