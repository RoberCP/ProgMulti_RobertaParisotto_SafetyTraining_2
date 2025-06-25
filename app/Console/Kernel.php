<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Defina o agendamento de comandos Artisan.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Rodar o comando de verificar prazos todos os dias às 8h
        $schedule->command('cursos:verificar-prazos')->dailyAt('08:00');
    }

    /**
     * Registre os comandos Artisan para a aplicação.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
