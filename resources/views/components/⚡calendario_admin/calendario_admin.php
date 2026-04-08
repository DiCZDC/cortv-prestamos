<?php

use App\Models\Solicitud;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Omnia\LivewireCalendar\LivewireCalendar;

new class extends LivewireCalendar
{
    public $events = [];

    public function events(): Collection
    {
        $solicitudes = Solicitud::query()
            ->whereBetween('fecha_prestamo', [now()->startOfMonth(), now()->endOfMonth()])
            ->orWhereBetween('fecha_devolucion', [now()->startOfMonth(), now()->endOfMonth()])
            // ->where('fecha_prestamo', '>=', now())
            ->get();
        $entregas = $solicitudes
            ->map(function (Solicitud $solicitud) {
                return [
                    'id' => $solicitud->id,
                    'title' => 'Entrega de préstamo para: '.Str::limit((string) $solicitud->motivo, 15, '...'),
                    'description' => "Solicitante: {$solicitud->trabajador->name} ",
                    'date' => Carbon::parse($solicitud->fecha_prestamo)->toDateString(),
                    'estado' => $solicitud->estado,
                ];
            });
        $devoluciones = $solicitudes
            ->map(function (Solicitud $solicitud) {
                return [
                    'id' => $solicitud->id,
                    'title' => 'Recepción de devolución para: '.Str::limit((string) $solicitud->motivo, 15, '...'),
                    'description' => "Solicitante: {$solicitud->trabajador->name} ",
                    'date' => Carbon::parse($solicitud->fecha_devolucion)->toDateString(),
                    'estado' => $solicitud->estado,
                ];
            });

        return $entregas->merge($devoluciones);
    }
    public function onEventClick($eventId)
    {
        $solicitud = Solicitud::find($eventId);
        if ($solicitud) {
            return redirect()->route('archivo.show', $solicitud->id);
        }
    }   
};
