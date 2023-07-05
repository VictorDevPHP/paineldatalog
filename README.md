<details>
  <summary>Mudanças no Projeto 03/06/2023</summary>

![gif](public/gif.gif)

## Arquivos Deletados
- `app/Http/Controllers/CurrencyApiServiceController.php`
- `public/vendor/adminlte/dist/css/adminlte.css`
- `resources/views/pages.blade.php`

## Novos Arquivos
- `app/Http/Controllers/DatalogController.php`
- `app/Http/Controllers/EquipamentoController.php`
- `app/Http/Controllers/LogeventController.php`
- `app/Http/Controllers/PainelconfController.php`
- `app/Http/Controllers/VisaoGeralController.php`
- `app/Models/Datalog.php`
- `app/Models/Equipamentos.php`
- `app/Models/Logevent.php`
- `public/css/table.css`
- `public/js/table.js`
- `public/loading.gif`
- `resources/css/admin_custom.css`
- `resources/views/nav/datalogs.blade.php`
- `resources/views/nav/equipamentos.blade.php`
- `resources/views/nav/logevents.blade.php`
- `resources/views/nav/painelconf.blade.php`
- `resources/views/nav/visaogeral.blade.php`

## Arquivos Modificados
- `composer.lock`
- `config/adminlte.php`
- `package-lock.json`
- `package.json`
- `public/vendor/adminlte/dist/css/adminlte.min.css`
- `resources/views/home.blade.php`
- `routes/web.php`
</details>

<details>
  <summary>Mudanças no Projeto 03/06/2023</summary>

# Mudanças no Projeto 03/06/2023

- `README.md`
- `app/Console/Kernel.php`
- `app/Http/Controllers/VisaoGeralController.php`
- `public/vendor/adminlte/dist/css/adminlte.css.map`
- `public/vendor/adminlte/dist/css/adminlte.min.css.map`
- `resources/views/nav/equipamentos.blade.php`
- `resources/views/nav/visaogeral.blade.php`
- `routes/web.php`    

## A função schedule é responsável por agendar e executar o ping em uma lista de equipamentos a cada três minutos. 

O código a seguir mostra o agendamento de verificação de ping em intervalos de três minutos.
```php 
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
``` 
Este código utiliza a biblioteca Schedule para agendar a verificação de ping em equipamentos específicos. A cada três minutos, o código executa um ping em cada equipamento, verifica o resultado do ping e atualiza o status no banco de dados. O log de saída do ping é registrado para fins de monitoramento e solução de problemas.
</details>

<details>
     <summary>Mudanças no Projeto 03/06/2023</summary>

## Arquivos Modificados

- `README.md`
- `app/Http/Controllers/EquipamentoController.php`
- `app/Http/Controllers/VisaoGeralController.php`
- `resources/views/nav/visaogeral.blade.php`
</details>