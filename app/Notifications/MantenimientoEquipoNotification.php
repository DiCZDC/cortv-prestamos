<?php

namespace App\Notifications;

use App\Models\Unidad_Equipo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MantenimientoEquipoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private Unidad_Equipo $equipoUnidad,
        private bool $enMantenimiento
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $estado = $this->enMantenimiento ? 'ingresado en' : 'sacado de';
        
        return (new MailMessage)
            ->subject('Actualización de Mantenimiento de Equipo')
            ->line("El equipo {$this->equipoUnidad->id} ha sido {$estado} mantenimiento.")
            ->action('Ver Equipos', route('equipos.show', ['id' => $this->equipoUnidad->id_equipo]))
            ->line('Gracias por usar nuestra aplicación.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $estado = $this->enMantenimiento ? 'ingresado en' : 'sacado de';
        $variant = $this->enMantenimiento ? 'warning' : 'success';
        
        return [
            'heading' => 'Equipo Actualizado',
            'text' => "El equipo {$this->equipoUnidad->id} ha sido {$estado} mantenimiento.",
            'variant' => $variant,
            'id_unidad_equipo' => $this->equipoUnidad->id,
            'en_mantenimiento' => $this->enMantenimiento,
        ];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        $estado = $this->enMantenimiento ? 'ingresado en' : 'sacado de';
        $variant = $this->enMantenimiento ? 'warning' : 'success';
        
        return [
            'heading' => 'Equipo Actualizado',
            'text' => "El equipo {$this->equipoUnidad->id} ha sido {$estado} mantenimiento.",
            'variant' => $variant,
            'id_unidad_equipo' => $this->equipoUnidad->id,
            'en_mantenimiento' => $this->enMantenimiento,
        ];
    }
}
