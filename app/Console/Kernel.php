<?php

namespace App\Console;
use App\Models\Equipamentos;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $equipamentos = Equipamentos::all();
    
            foreach ($equipamentos as $equipamento) {
                $ip = $equipamento->ip;
    
                // Executa o comando de ping
                $pingOutput = [];
                $pingResult = -1;
                exec("ping -c 1 $ip", $pingOutput, $pingResult);
    
                \Log::info('Ping Output: ' . implode(PHP_EOL, $pingOutput));
    
                // Verifica o resultado do ping
                $comunicando = false;
                foreach ($pingOutput as $outputLine) {
                    if (strpos($outputLine, 'Recebidos = 4') !== false) {
                        $comunicando = true;
                        break;
                    }
                }
    
                // Atualiza o status do equipamento no banco de dados
                $equipamento->status = $comunicando ? 'Comunicando' : 'Não comunicando';
                $equipamento->save();
            }
            \Illuminate\Support\Facades\Log::info('Ping executado com sucesso.');
    
        })->everyThreeMinutes();
    }
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
