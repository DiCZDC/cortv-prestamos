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

    public string $today;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->today = now()->toDateString();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->trabajadores();
        $this->admins();
    }


    public function prestamos_pendientes(){
        return Solicitud::where('estado','Pendiente')
            ->count();
    }

    public function prestamos_por_entregar(){
        $solicitudes = Solicitud::where('estado','Autorizada')
            ->where(function($query) {
                $query->whereDate('fecha_prestamo', now()->toDateString())
                    ->orWhereDate('fecha_prestamo', now()->addDay()->toDateString());
            })
            ->get();
        $todos = [];
        foreach ($solicitudes as $solicitud) {
            $act=[
                'header' => 'Recordatorio de Préstamo',
                'esHoy' => Carbon::parse($solicitud->fecha_prestamo)->toDateString() == now()->toDateString(),
                'motivo'=>$solicitud->motivo,
                'id' => $solicitud->id
            ];
            array_push($todos,$act);
        }
        return $todos;
        
    }



    
    public function trabajadores()
    {

        // $solicitudes = Solicitud::whereDate('fecha_devolucion', now()->toDateString())
        //     ->orWhereDate('fecha_devolucion', now()->addDay()->toDateString())
        //     ->get();

        // foreach ($solicitudes as $solicitud) {
        //     $user = $solicitud->trabajador;
        //     if (! $user) {
        //         continue;
        //     }

        //     $fechaDevolucion = Carbon::parse($solicitud->fecha_devolucion)->toDateString();
        //     $esHoy = $fechaDevolucion === now()->toDateString();
        //     $mensaje = $esHoy
        //         ? 'El día de hoy es la fecha limite para devolver el prestamo '.$solicitud->motivo
        //         : 'El día de mañana es la fecha limite para devolver el prestamo '.$solicitud->motivo;

        //     Notification::send($user, new solicitud_notification(
        //         'Recordatorio de Devolución',
        //         $mensaje,
        //         '/archivo/'.$solicitud->id
        //     ));
        // }
    }

    public function admins()
    {
        $prestamosPorEntregar = $this->prestamos_por_entregar();
        foreach ($prestamosPorEntregar as $prestamo) {
            // Log::info('Contenido de prestamo', ['prestamo' => $prestamo]);
            Notification::send(User::role('admin')->get(), new solicitud_notification(
                'Recordatorio de Préstamo',
                $prestamo['esHoy'] ? 'El día de hoy se debe entregar el prestamo con motivo '.$prestamo['motivo'] : 'El día de mañana se debe entregar el prestamo con motivo '.$prestamo['motivo'],
                "entrega/{{$prestamo['id']}}"
            ));
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Error al procesar recordatorios: '.$exception->getMessage());
    }
}
