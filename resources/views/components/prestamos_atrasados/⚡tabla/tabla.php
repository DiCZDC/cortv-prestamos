<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\{
    Solicitud_Equipo,
    Equipo,
    User
};

use Illuminate\Support\Carbon;


new class extends Component
{
    use WithPagination;
    #[Computed]
    public function atrasados()
    {
        return Solicitud_Equipo::query()
        ->join('solicituds', 'solicitud__equipos.id_solicitud', '=', 'solicituds.id')
        ->where('solicituds.fecha_devolucion', '<', now()) 
        ->where('solicituds.fecha_devolucion', '>=', now()->subDays(30))
        ->where('solicituds.estado', 'Entregada')
        ->join('users', 'solicituds.id_trabajador', '=', 'users.id')
        ->select('solicitud__equipos.*', 'users.name as nombre_trabajador')
        ->orderBy('solicituds.fecha_prestamo', 'desc')
        ->paginate(5);
    }   
};
