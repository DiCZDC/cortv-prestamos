<?php

use Livewire\Component;
use App\Models\{
    Solicitud_Equipo,
    Solicitud
    };
use Livewire\Attributes\Computed;

new class extends Component
{
    public $solicitudId;

    public function mount($solicitudId)
    {
        $this->solicitudId = $solicitudId;
    }

    #[Computed]
    public function detalles()
    {
        return Solicitud_Equipo::where('id_solicitud', $this->solicitudId)->get();
    }   

    #[Computed]
    public function solicitud($id_equipo)
    {
        $hoy = now()->toDateString();

        $total = Solicitud::join('solicitud__equipos', 'solicituds.id', '=', 'solicitud__equipos.id_solicitud')
            ->join('unidad__equipos', 'unidad__equipos.id', '=', 'solicitud__equipos.id_unidad_Equipo')
            ->where('solicituds.estado', 'Autorizada')
            ->where('unidad__equipos.id', $id_equipo)
            ->whereRaw('? BETWEEN solicituds.fecha_prestamo AND solicituds.fecha_entrega', [$hoy])
            ->distinct('solicituds.id')
            ->count('solicituds.id');
        return $total == 0? true : false;
    }
};