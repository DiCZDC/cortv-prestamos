<?php

use App\Models\Solicitud_Equipo;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $id_user = null;

    #[Computed]
    public function atrasados()
    {
        $user = $this->id_user ? User::find($this->id_user) : auth()->user();

        return Solicitud_Equipo::query()
            ->join('solicituds', 'solicitud__equipos.id_solicitud', '=', 'solicituds.id')
            // Filtrar por fecha de devolución menor a la fecha actual y mayor o igual a 30 días atrás
            ->where('solicituds.fecha_devolucion', '<', now())
            ->where('solicituds.fecha_devolucion', '>=', now()->subDays(30))
            // La solicitud debe estar en estado "Entregada" y no "Devuelta"
            ->where('solicituds.estado', 'Entregada')
            ->join('users', 'solicituds.id_trabajador', '=', 'users.id')
            ->select('solicitud__equipos.*', 'users.name as nombre_trabajador')
            ->orderBy('solicituds.fecha_devolucion', 'asc')
            ->when($user->hasRole('trabajador'), function ($query) use ($user) {
                $query->where('solicituds.id_trabajador', $user->id);
            })
            ->paginate(4);
    }
};
