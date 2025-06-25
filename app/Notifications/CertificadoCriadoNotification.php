<?php

namespace App\Notifications;

use App\Models\Certificado;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CertificadoCriadoNotification extends Notification
{
    use Queueable;

    public $certificado;

    public function __construct(Certificado $certificado)
    {
        $this->certificado = $certificado;
    }

    public function via($notifiable)
    {
        return ['mail']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Novo Certificado Criado')
            ->greeting('Olá, ' . $notifiable->name)
            ->line('Um novo certificado foi criado com os seguintes dados:')
            ->line('Curso: ' . $this->certificado->curso->nomeCurso)
            ->line('Funcionário: ' . $this->certificado->funcionario->nome)
            ->line('Data de emissão: ' . $this->certificado->dataEmissao)
            ->action('Ver Certificados', url('/certificados'))
            ->line('Obrigado por usar o Safety Training!');
    }
}
