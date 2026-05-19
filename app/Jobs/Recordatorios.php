<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Model\User;
use App\Notifications\solicitud_notification;


use Illuminate\Support\Facades\Log;

class Recordatorios implements ShouldQueue
{
    use Dispatchable,InteractsWithQueue,Queueable,SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        echo "Ejecutando el job de recordatorios<br>";
        info('Ejecutando el job de recordatorios');
        // Notification::send(User::where('is_admin', true)->get(), new solicitud_notification(
        //     'Recordatorio de Préstamo',
        //     'El día de hoy se debe entregar el prestamo con motivo X',
        //     'entrega/1'
        // ));
    }
}
