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

    public function realizarPing()
    {
        // Obtém todos os equipamentos do banco de dados
        $equipamentos = Equipamento::all();

        $naoComunicantes = 0;

        foreach ($equipamentos as $equipamento) {
            $ip = $equipamento->ip;

            // Executa o comando de ping
            $pingOutput = [];
            $pingResult = -1;
            exec("ping -c 1 $ip", $pingOutput, $pingResult);

            // Verifica o resultado do ping
            $comunicando = ($pingResult === 0);

            // Atualiza o status do equipamento no banco de dados
            $equipamento->status = $comunicando ? 'Comunicando' : 'Não comunicando';
            $equipamento->save();

            if (!$comunicando) {
                $naoComunicantes++;
            }
        }

        // Faça o que precisar com a quantidade de equipamentos não comunicantes
        // Por exemplo, você pode passar essa informação para a view
        return view('nav.visaogeral', ['visaogeral' => $naoComunicantes]);
    }

}
