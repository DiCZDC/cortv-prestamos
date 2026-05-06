<?php

namespace App\Jobs;

use App\Models\Solicitud;
use App\Models\User;
use App\Notifications\solicitud_notification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ProcesarRecordatorios implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 30;

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
        $this->trabajadores();
        $this->admins();
    }

    public function trabajadores()
    {
        $today = now()->toDateString();

        $solicitudes = Solicitud::whereDate('fecha_devolucion', now()->toDateString())
            ->orWhereDate('fecha_devolucion', now()->addDay()->toDateString())
            ->get();

        foreach ($solicitudes as $solicitud) {
            $user = $solicitud->trabajador;
            if (! $user) {
                continue;
            }

            $fechaDevolucion = Carbon::parse($solicitud->fecha_devolucion)->toDateString();
            $esHoy = $fechaDevolucion === now()->toDateString();
            $mensaje = $esHoy
                ? 'El día de hoy es la fecha limite para devolver el prestamo '.$solicitud->motivo
                : 'El día de mañana es la fecha limite para devolver el prestamo '.$solicitud->motivo;

            Notification::send($user, new solicitud_notification(
                'Recordatorio de Devolución',
                $mensaje,
                '/archivo/'.$solicitud->id
            ));
        }
    }

    public function admins()
    {
        $today = now()->toDateString();

        $solicitudes = Solicitud::whereDate('fecha_prestamo', now()->toDateString())
            ->orWhereDate('fecha_prestamo', now()->addDay()->toDateString())
            ->get();

        foreach ($solicitudes as $solicitud) {

            $fechaPrestamo = Carbon::parse($solicitud->fecha_prestamo)->toDateString();
            $esHoy = $fechaPrestamo === now()->toDateString();
            $mensaje = $esHoy
                ? 'El día de hoy es la fecha de préstamo para: '.$solicitud->motivo
                : 'El día de mañana es la fecha de préstamo para: '.$solicitud->motivo;

            Notification::send(User::role('admin')->get(), new solicitud_notification(
                'Recordatorio de Préstamo',
                $mensaje,
                '/archivo/'.$solicitud->id
            ));
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Error al procesar recordatorios: '.$exception->getMessage());
    }
}
