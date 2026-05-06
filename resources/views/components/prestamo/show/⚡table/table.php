<?php

use App\http\Controllers\PrestamoController;
use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use App\Models\Unidad_Equipo;
use Flux\Flux;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $from;

    public $to;

    public $solicitudId;

    public array $unidadesSeleccionadas = [];

    public array $detallesConfirmados = [];

    public function mount($solicitudId)
    {
        Solicitud::findOrFail($solicitudId);
        $this->solicitudId = $solicitudId;

        $this->inicializarReemplazos();
    }

    protected function inicializarReemplazos(): void
    {
        $detalles = Solicitud_Equipo::where('id_solicitud', $this->solicitudId)->get();

        foreach ($detalles as $detalle) {
            $detalleId = (string) $detalle->id;
            $this->unidadesSeleccionadas[$detalleId] = (int) $detalle->Unidad_Equipo->id;
            $this->detallesConfirmados[$detalleId] = false;
        }
    }

    protected function esReemplazoValido($detalle, int $unidadSeleccionadaId): bool
    {
        if ($unidadSeleccionadaId === (int) $detalle->Unidad_Equipo->id) {
            return false;
        }

        return $this->equipos_libres($detalle->Unidad_Equipo->Equipo->id)
            ->pluck('id')
            ->contains($unidadSeleccionadaId);
    }

    public function updatedUnidadesSeleccionadas($value, $key): void
    {
        $detalle = Solicitud_Equipo::find($key);

        if (! $detalle) {
            return;
        }

        if (! $this->esReemplazoValido($detalle, (int) $value)) {
            $this->detallesConfirmados[$key] = false;
        }
    }

    #[Computed]
    public function solicitudInfo()
    {
        return Solicitud::findOrFail($this->solicitudId);
    }

    #[Computed]
    public function detalles()
    {
        return Solicitud_Equipo::where('id_solicitud', $this->solicitudId)->get()
            ->map(function ($detalle) {
                $detalle->Disponible = $this->equipos_libres($detalle->Unidad_Equipo->Equipo->id)->pluck('id')->contains($detalle->Unidad_Equipo->id);

                return $detalle;
            });
    }

    #[Computed]
    public function conflictosPendientes()
    {
        return $this->detalles()->contains(function ($detalle) {
            if ($detalle->Disponible) {
                return false;
            }

            $detalleId = (string) $detalle->id;
            $unidadSeleccionadaId = (int) ($this->unidadesSeleccionadas[$detalleId] ?? $detalle->Unidad_Equipo->id);
            $confirmado = (bool) ($this->detallesConfirmados[$detalleId] ?? false);

            if (! $confirmado) {
                return true;
            }

            return ! $this->esReemplazoValido($detalle, $unidadSeleccionadaId);
        });
    }

    #[Computed]
    public function solicitud($id_equipo)
    {
        $hoy = now()->toDateString();

        $total = Solicitud::join('solicitud__equipos', 'solicituds.id', '=', 'solicitud__equipos.id_solicitud')
            ->join('unidad__equipos', 'unidad__equipos.id', '=', 'solicitud__equipos.id_unidad_equipo')
            ->where('solicituds.estado', 'Autorizada')
            ->where('unidad__equipos.id', $id_equipo)
            ->whereRaw('? BETWEEN solicituds.fecha_prestamo AND solicituds.fecha_entrega', [$hoy])
            ->distinct('solicituds.id')
            ->count('solicituds.id');

        return $total == 0 ? true : false;
    }

    #[Computed]
    public function equipos_ocupados()
    {
        if (empty($this->from) || empty($this->to)) {
            return collect();
        }
        $prestados_1 = Solicitud::whereIn('estado', ['Entregada', 'Autorizada'])->whereBetween('fecha_prestamo', [$this->from, $this->to])->pluck('id');
        $prestados_2 = Solicitud::whereIn('estado', ['Entregada', 'Autorizada'])->whereBetween('fecha_devolucion', [$this->from, $this->to])->pluck('id');
        $prestados_3 = Solicitud::whereIn('estado', ['Autorizada', 'Entregada'])->where('fecha_prestamo', '<', $this->from)->where('fecha_devolucion', '>', $this->to)->pluck('id');
        $prestados = $prestados_1->merge($prestados_2)->merge($prestados_3)->unique();

        return Solicitud_Equipo::whereIn('id_solicitud', $prestados)
            ->pluck('id_unidad_equipo')
            ->unique();
    }

    public function equipos_libres($id)
    {
        return Unidad_Equipo::where('id_equipo', $id)
            ->whereNotIn('id', $this->equipos_ocupados())
            ->where('mantenimiento', false)  
            ->get();
    }

    public function autorizar()
    {
        if ($this->conflictosPendientes()) {
            Flux::toast(
                heading: 'Conflictos pendientes',
                text: 'Selecciona y confirma una unidad disponible para cada equipo en conflicto.',
                variant: 'warning',
            );

            return;
        }
        foreach ($this->detalles() as $detalle) {

            $detalleId = (string) $detalle->id;
            $unidadSeleccionadaId = (int) ($this->unidadesSeleccionadas[$detalleId] ?? $detalle->Unidad_Equipo->id);

            if ($this->esReemplazoValido($detalle, $unidadSeleccionadaId)) {
                Solicitud_Equipo::where('id', $detalle->id)->update([
                    'id_unidad_equipo' => $unidadSeleccionadaId,
                ]);
            }
        }

        try {
            $this->actualizar('Autorizada');

        } catch (Exception $e) {
            Flux::toast(heading: 'Error', text: $e->getMessage(), variant: 'danger');
        }
    }

    public function rechazar()
    {
        try {
            $this->actualizar('Rechazada');
        } catch (Exception $e) {
            Flux::toast(heading: 'Error', text: $e->getMessage(), variant: 'danger');
        }
    }

    public function actualizar($estado)
    {
        app(PrestamoController::class)->update(new Request([
            'solicitud_id' => $this->solicitudId,
            'estado' => $estado,
            'id_admin' => Auth::user()->id,
        ]));
        $solicitud = Solicitud::find($this->solicitudId);
        Flux::toast(
            heading: $estado === 'Autorizada' ? 'Solicitud autorizada' : 'Solicitud rechazada',
            text: 'La solicitud de préstamo de '.$solicitud->trabajador->name.' fue '.($estado === 'Autorizada' ? 'autorizada' : 'rechazada').'.',
            variant: $estado === 'Autorizada' ? 'success' : 'danger',
        );
    }
};
