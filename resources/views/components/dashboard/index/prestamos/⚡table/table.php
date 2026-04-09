<?php

use App\Models\Solicitud_Equipo;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function prestamos()
    {
        return Solicitud_Equipo::query()
            ->join('solicituds', 'solicitud__equipos.id_solicitud', '=', 'solicituds.id')
            ->where('solicituds.estado', 'Autorizada')
            ->where('solicituds.fecha_prestamo', '>', now())
            ->join('users', 'solicituds.id_trabajador', '=', 'users.id')
            ->select('solicitud__equipos.*', 'users.name as nombre_trabajador')
            ->orderBy('solicituds.fecha_prestamo', 'asc')
            ->paginate(5);
    }
};
