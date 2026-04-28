<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Notifications\solicitud_notification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RecordatorioController extends Controller
{

    public function __invoke()
    {
        $this->recordatorios();
    }
    public function recordatorios()
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
                ? 'El día de hoy es la fecha limite para devolver el equipo del prestamo ' . $solicitud->motivo
                : 'El día de mañana es la fecha limite para devolver el equipo del prestamo ' . $solicitud->motivo;

            $yaFueNotificadoHoy = DatabaseNotification::query()
                ->where('notifiable_type', get_class($user))
                ->where('notifiable_id', $user->getKey())
                ->where('type', solicitud_notification::class)
                ->whereDate('created_at', $today)
                ->where('data->url', url('/archivo/' . $solicitud->id))
                ->exists();

            if ($yaFueNotificadoHoy) {
                continue;
            }

            Notification::send($user, new solicitud_notification(
                'Recordatorio de Devolución',
                $mensaje,
                '/archivo/' . $solicitud->id
            ));
        }


    }
}
