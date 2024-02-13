<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ValidarCiclosNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($alumno, $ciclo)
    {
        $this->alumno = $alumno;
        $this->ciclo = $ciclo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Desea validar el ciclo de '. $this->ciclo->cliteral . " del alumno ". $this->alumno->user->name . "?")
                    ->line('Año de finalización: '. $this->alumno->ciclos()->where('idCiclo', $this->ciclo->id)->first()->pivot->finalizacion)
                    ->action('Validar', url('/alumnos/activar/' . $this->alumno->idUsuario ."/".$this->ciclo->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
