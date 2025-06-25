<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Curso;
use App\Notifications\CursoAtualizadoNotification;
use Carbon\Carbon;

class VerificarPrazosReciclagem extends Command
{
    protected $signature = 'cursos:verificar-prazos';
    protected $description = 'Verifica cursos próximos do prazo de reciclagem e notifica os usuários.';

    public function handle()
    {
        $hoje = Carbon::today();
        $limite = $hoje->copy()->addDays(7); // notificar cursos com prazo até 7 dias

        $cursos = Curso::whereBetween('prazoRecicla', [$hoje, $limite])->get();

        foreach ($cursos as $curso) {
            $usuarios = $curso->empresa->users;
            foreach ($usuarios as $usuario) {
                $usuario->notify(new CursoAtualizadoNotification($curso));
            }
        }

        $this->info('Notificações enviadas para cursos próximos do prazo.');
    }
}