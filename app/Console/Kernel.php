<?php

namespace App\Console;

use App\Models\Datalog;
use App\Models\Equipamentos;
use App\Models\Logevent;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// Importe o namespace apropriado que contém a função getBatteryCapacity()
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    protected function schedule(Schedule $schedule): void
    {
        // Verificação do status do equipamento
        // $schedule->call(function () {
        //     $equipamentos = Equipamentos::all();

        //     foreach ($equipamentos as $equipamento) {
        //         $ip = $equipamento->ip;

        //         // Executa o comando de ping
        //         $pingOutput = [];
        //         $pingResult = -1;
        //         exec("ping -c 1 $ip", $pingOutput, $pingResult);

        //         \Log::info('Ping Output: ' . implode(PHP_EOL, $pingOutput));

        //         // Verifica o resultado do ping
        //         $comunicando = false;
        //         foreach ($pingOutput as $outputLine) {
        //             if (strpos($outputLine, 'Recebidos = 4') !== false) {
        //                 $comunicando = true;
        //                 break;
        //             }
        //         }

        //         // Atualiza o status do equipamento no banco de dados
        //         $equipamento->status = $comunicando ? 'Comunicando' : 'Não comunicando';
        //         $equipamento->save();
        //     }
        //     \Illuminate\Support\Facades\Log::info('Ping executado com sucesso.');

        // })->everyTwoMinutes();

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        // latestCapacity = capacidade mais recente
        // previous Capacity = capacidade anterior
        $schedule->call(function () {
            $equipamentos = Equipamentos::all();

            foreach ($equipamentos as $equipamento) {
                $latestCapacity = Datalog::where('id_equipamento', $equipamento->id)
                    ->orderBy('data_hora', 'desc')
                    ->value('Battery_capacity');

                $previousCapacity = Datalog::where('id_equipamento', $equipamento->id)
                    ->orderBy('data_hora', 'desc')
                    ->skip(1)
                    ->value('Battery_capacity');

                if ($previousCapacity == 100 && $latestCapacity != 100) {
                    // Registra um novo log apenas quando a bateria sai de 100
                    $logMessage = "O status da bateria do equipamento {$equipamento->id} saiu de 100%.";
                    $log = new Logevent();
                    $log->id_equipamento = $equipamento->id;
                    $log->data_cadastro = Carbon::now();
                    $log->log = $logMessage;
                    $log->save();

                    $equipamento->log_gravado = false;
                    $equipamento->save();
                    Log::info("Log gravado com sucesso para o equipamento {$equipamento->id}");

                } elseif ($previousCapacity != 100 && $latestCapacity == 100) {
                    // Registra um novo log apenas quando a bateria volta para 100
                    $logMessage = "O status da bateria do equipamento {$equipamento->id} voltou para 100%.";
                    $log = new Logevent();
                    $log->id_equipamento = $equipamento->id;
                    $log->data_cadastro = Carbon::now();
                    $log->log = $logMessage;
                    $log->save();

                    $equipamento->log_gravado = false;
                    $equipamento->save();
                    Log::info("Log gravado com sucesso para o equipamento {$equipamento->id}");

                } elseif ($latestCapacity <= 10 && $equipamento->log_gravado == false) {
                    // Registra um novo log apenas quando a bateria está abaixo de 10 e o log correspondente ainda não foi gravado
                    $logMessage = "A capacidade da bateria do equipamento está abaixo de 10%. A UPS será desligada.";
                    $log = new Logevent();
                    $log->id_equipamento = $equipamento->id;
                    $log->data_cadastro = Carbon::now();
                    $log->log = $logMessage;
                    $log->save();

                    $equipamento->log_gravado = true;
                    $equipamento->save();

                    $logMessage = "A UPS voltou de uma bateria fraca..";
                    $log = new Logevent();
                    $log->id_equipamento = $equipamento->id;
                    $log->data_cadastro = Carbon::now();
                    $log->log = $logMessage;
                    $log->save();

                    $equipamento->log_gravado = true;
                    $equipamento->save();
                    Log::info("Log gravado com sucesso para o equipamento {$equipamento->id}");
                }
            }
            Log::info("Verificação de bateria realizada com sucesso");
        })->everyMinute();

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$schedule->call(function () {
    $equipamentos = Equipamentos::all();

    foreach ($equipamentos as $equipamento) {
        $InputAtual = Datalog::where('id_equipamento', $equipamento->id)
            ->orderBy('data_hora', 'desc')
            ->value('input_type');

        $InputAnterior = Datalog::where('id_equipamento', $equipamento->id)
            ->orderBy('data_hora', 'desc')
            ->skip(1)
            ->value('input_type');

        if($InputAnterior == 3 && $InputAtual == 4){
            $logMessage = "Interruptor Estático no Modo Bypass";
            $log = new Logevent();
            $log->id_equipamento = $equipamento->id;
            $log->data_cadastro = Carbon::now();
            $log->log = $logMessage;
            $log->save();
        }

    }

    Log::info("Verificação de input type realizada com sucesso");
})->everyMinute();




//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

        // // Tarefa para criar backup do banco de dados
        $backupDirectory = storage_path('app\database');
        $backupFileName = 'backup.sql';
        $backupFilePath = $backupDirectory . '/' . $backupFileName;

        $schedule->exec("mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > $backupFilePath")
            ->everyMinute()
            ->runInBackground();

        // Log::info('Rotina de backup agendada com sucesso.');

    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
