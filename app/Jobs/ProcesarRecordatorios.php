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

    public function notificator($user, $header, $message, $url)
    {
        Notification::send($user, new solicitud_notification(
            $header,
            $message,
            $url
        ));

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
                'tipo'=>'prestamo',
                'esHoy' => Carbon::parse($solicitud->fecha_prestamo)->toDateString() == now()->toDateString(),
                'motivo'=>$solicitud->motivo,
                'id' => $solicitud->id,
                'id_trabajador' => $solicitud->trabajador()->first()->id
            ];
            array_push($todos,$act);
        }
        return $todos;
    }

    public function recepciones_proximas(){
        $recepciones = Solicitud::where('estado','Entregada')
            ->where(function($query) {
                $query->whereDate('fecha_devolucion', now()->toDateString())
                    ->orWhereDate('fecha_devolucion', now()->addDay()->toDateString());
            })
            ->get();
        $todos = [];
        foreach ($recepciones as $recepcion) {
            $act=[
                'header' => 'Recordatorio de Recepción',
                'tipo'=>'recepción',
                'esHoy' => Carbon::parse($recepcion->fecha_devolucion)->toDateString() == now()->toDateString(),
                'motivo'=>$recepcion->motivo,
                'id' => $recepcion->id,
                'id_trabajador' => $recepcion->trabajador()->first()->id
            ];
            array_push($todos,$act);
        }
        return $todos;
    }


    
    public function trabajadores()
    {
        $prestamosPorEntregar = array_merge(
            $this->prestamos_por_entregar(),
            $this->recepciones_proximas()
        );
        foreach ($prestamosPorEntregar as $prestamo) {
            $header = 'Recordatorio de '.$prestamo['tipo'];
            $mensaje = 'El día de '.($prestamo['esHoy'] ? 'hoy ' : 'mañana').' debes '.($prestamo['tipo'] == 'prestamo' ? 'recoger' : 'entregar').' el prestamo con motivo:'.$prestamo['motivo'];
            $this->notificator(User::find($prestamo['id_trabajador']), $header, $mensaje, '/entrega/'.$prestamo['id']);
        }

        // $recepcionesProximas = $this->recepciones_proximas();
        // foreach ($recepcionesProximas as $recepcion) {
        //     $this->notificator(User::find($recepcion['id_trabajador']), $recepcion['header'], 'El día de '.($recepcion['esHoy'] ? 'hoy ' : 'mañana').' debes entregar el prestamo con motivo:'.$recepcion['motivo'], '/recepcion/'.$recepcion['id']);
        // }


    }

    public function admins()
    {
        if($this->prestamos_pendientes() > 0){
            Notification::send(User::role('admin')->get(), new solicitud_notification(
                'Recordatorio de Préstamos Pendientes',
                'Actualmente hay '.$this->prestamos_pendientes().' préstamos pendientes de autorización.',
                '/prestamo'
            ));
        }
        $prestamosPorEntregar = $this->prestamos_por_entregar();
        foreach ($prestamosPorEntregar as $prestamo) {
            Notification::send(User::role('admin')->get(), new solicitud_notification(
                $prestamo['header'],
                "El día de ". ($prestamo['esHoy'] ? 'hoy' : 'mañana') ." se debe entregar el prestamo con motivo ".$prestamo['motivo'] ." \nSolicitado por: ". User::find($prestamo['id_trabajador'])->name ,
                '/entrega/'.$prestamo['id']
            ));
        }

        $recepcionesProximas = $this->recepciones_proximas();
        foreach ($recepcionesProximas as $recepcion) {
            Notification::send(User::role('admin')->get(), new solicitud_notification(
                $recepcion['header'],
                "El día de ".($recepcion['esHoy'] ? 'hoy' : 'mañana')." se debe recibir el prestamo con motivo ".$recepcion['motivo']."\nSolicitado por: ".User::find($recepcion['id_trabajador'])->name ,
                '/recepcion/'.$recepcion['id']
            ));
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Error al procesar recordatorios: '.$exception->getMessage());
    }
}
