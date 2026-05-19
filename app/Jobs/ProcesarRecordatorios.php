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
    public function __construct()
    {
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
                'id' => $solicitud->id,
                'id_trabajador' => $solicitud->trabajador()->first()->id
            ];
            array_push($todos,$act);
        }
        return $todos;
        
    }



    
    public function trabajadores()
    {
        $prestamosPorEntregar = $this->prestamos_por_entregar();
        foreach ($prestamosPorEntregar as $prestamo) {
            $user = User::find($prestamo['id_trabajador']);
            Notification::send($user, new solicitud_notification(
                'Recordatorio de Préstamo',
                'El día de '.($prestamo['esHoy'] ? 'hoy ' : 'mañana').' debes recoger el prestamo con motivo:'.$prestamo['motivo'],
                '/entrega/'.$prestamo['id']
            ));
        }
    }

    public function admins()
    {
        
        Notification::send(User::role('admin')->get(), new solicitud_notification(
            'Recordatorio de Préstamos Pendientes',
            'Actualmente hay '.$this->prestamos_pendientes().' préstamos pendientes de autorización.',
            '/prestamo'
        ));
        $prestamosPorEntregar = $this->prestamos_por_entregar();
        foreach ($prestamosPorEntregar as $prestamo) {
            Notification::send(User::role('admin')->get(), new solicitud_notification(
                'Recordatorio de Préstamo',
                $prestamo['esHoy'] ? 'El día de hoy se debe entregar el prestamo con motivo '.$prestamo['motivo'] .' solicitado por: '. User::find($prestamo['id_trabajador'])->name : 'El día de mañana se debe entregar el prestamo con motivo '.$prestamo['motivo'].' solicitado por: '. User::find($prestamo['id_trabajador'])->name ,
                '/entrega/'.$prestamo['id']
            ));
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Error al procesar recordatorios: '.$exception->getMessage());
    }
}
