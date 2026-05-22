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
use Illuminate\Support\Facades\Notification;

class ProcesarRecordatorios implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 30;

    // public string $today;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->trabajadores();
        $this->admins();
    }

    public function notificator($user, $header, $message, $url)
    {
        Notification::send($user, new solicitud_notification(
            $header,
            $message,
            $url
        ));

    }

    public function prestamos_pendientes()
    {
        return Solicitud::where('estado', 'Pendiente')
            ->count();
    }

    public function prestamos_por_entregar()
    {
        $solicitudes = Solicitud::where('estado', 'Autorizada')
            ->where(function ($query) {
                $query->whereDate('fecha_prestamo', now()->toDateString())
                    ->orWhereDate('fecha_prestamo', now()->addDay()->toDateString());
            })
            ->get();
        $todos = [];
        foreach ($solicitudes as $solicitud) {
            $act = [
                'header' => 'Recordatorio de Préstamo',
                'tipo' => 'prestamo',
                'esHoy' => Carbon::parse($solicitud->fecha_prestamo)->toDateString() == now()->toDateString(),
                'motivo' => $solicitud->motivo,
                'id' => $solicitud->id,
                'id_trabajador' => $solicitud->trabajador()->first()->id,
            ];
            array_push($todos, $act);
        }

        return $todos;
    }

    public function recepciones_proximas()
    {
        $recepciones = Solicitud::where('estado', 'Entregada')
            ->where(function ($query) {
                $query->whereDate('fecha_devolucion', now()->toDateString())
                    ->orWhereDate('fecha_devolucion', now()->addDay()->toDateString());
            })
            ->get();
        $todos = [];
        foreach ($recepciones as $recepcion) {
            $act = [
                'header' => 'Recordatorio de Recepción',
                'tipo' => 'recepción',
                'esHoy' => Carbon::parse($recepcion->fecha_devolucion)->toDateString() == now()->toDateString(),
                'motivo' => $recepcion->motivo,
                'id' => $recepcion->id,
                'id_trabajador' => $recepcion->trabajador()->first()->id,
            ];
            array_push($todos, $act);
        }

        return $todos;
    }

    public function new_users()
    {
        return User::doesntHave('roles')->count();
    }

    public function trabajadores()
    {
        $prestamos = array_merge(
            $this->prestamos_por_entregar(),
            $this->recepciones_proximas()
        );
        foreach ($prestamos as $prestamo) {
            $header = 'Recordatorio de '.$prestamo['tipo'];
            $tipo = match ($prestamo['tipo']) {
                'prestamo' => 'recoger',
                'recepción' => 'devolver',
                default => 'realizar la acción correspondiente'
            };
            $mensaje = 'El día de '.($prestamo['esHoy'] ? 'hoy ' : 'mañana').' debes '.$tipo.' el prestamo con motivo:'.$prestamo['motivo'];

            $this->notificator(User::find($prestamo['id_trabajador']),
                $header,
                $mensaje,
                '/entrega/'.$prestamo['id']
            );
        }
    }

    public function admins()
    {
        if ($this->new_users() > 0) {
            $this->notificator(User::role('admin')->get(),
                'Recordatorio de Nuevos Usuarios',
                'Actualmente hay '.$this->new_users().' nuevos usuarios sin asignar rol.',
                '/personal'
            );
        }
        if ($this->prestamos_pendientes() > 0) {
            $this->notificator(User::role('admin')->get(),
                'Recordatorio de Préstamos Pendientes',
                'Actualmente hay '.$this->prestamos_pendientes().' préstamos pendientes de autorización.',
                '/prestamo'
            );
        }

        $prestamos = array_merge(
            $this->prestamos_por_entregar(),
            $this->recepciones_proximas()
        );
        foreach ($prestamos as $prestamo) {
            $header = 'Recordatorio de '.$prestamo['tipo'];
            $tipo = match ($prestamo['tipo']) {
                'prestamo' => 'entregar',
                'recepción' => 'recibir',
                default => 'realizar la acción correspondiente'
            };
            $mensaje = 'El día de '.($prestamo['esHoy'] ? 'hoy ' : 'mañana').' se debe '.$tipo.' el prestamo con motivo: '.$prestamo['motivo'].'Solicitado por: '.User::find($prestamo['id_trabajador'])->name;

            $this->notificator(User::role('admin')->get(),
                $header,
                $mensaje,
                '/entrega/'.$prestamo['id']
            );
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Error al procesar recordatorios: '.$exception->getMessage());
    }
}
