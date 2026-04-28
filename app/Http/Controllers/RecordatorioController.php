<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Notifications\solicitud_notification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class RecordatorioController extends Controller
{

    public function __invoke()
    {
        $this->recordatorios();
    }
    public function recordatorios()
    {
        Log::info('RecordatorioController::recordatorios() ejecutándose');

        $solicitudes = Solicitud::whereDate('fecha_devolucion', now()->toDateString())
            ->orWhereDate('fecha_devolucion', now()->addDay()->toDateString())
            ->get();

        foreach ($solicitudes as $solicitud) {
            $user = $solicitud->trabajador;
            $fechaDevolucion = Carbon::parse($solicitud->fecha_devolucion)->toDateString();
            $esHoy = $fechaDevolucion === now()->toDateString();
            $mensaje = $esHoy
                ? 'El día de hoy es la fecha limite para devolver el equipo del prestamo ' . $solicitud->motivo
                : 'El día de mañana es la fecha limite para devolver el equipo del prestamo ' . $solicitud->motivo;

            Notification::send($user, new solicitud_notification(
                'Recordatorio de Devolución',
                $mensaje,
                '/archivo/' . $solicitud->id
            ));
        }


        return response()->json(['message' => 'Recordatorios enviados a los usuarios con solicitudes pendientes.']);

    }
}
