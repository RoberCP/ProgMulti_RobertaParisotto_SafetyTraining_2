<?php

namespace App\Notifications;

use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CursoAtualizadoNotification extends Notification
{
    use Queueable;

    public $curso;

    public function __construct(Curso $curso)
    {
        $this->curso = $curso;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Curso concluído ou prazo próximo')
            ->line("O curso '{$this->curso->nomeCurso}' foi concluído ou está próximo da reciclagem.")
            ->action('Ver curso', url('/cursos'))
            ->line('Acompanhe no sistema os detalhes!');
    }

    public function toArray($notifiable)
    {
        return [
            'curso_id' => $this->curso->IdCurso,
            'mensagem' => "Curso '{$this->curso->nomeCurso}' concluído ou próximo da reciclagem.",
        ];
    }
}
