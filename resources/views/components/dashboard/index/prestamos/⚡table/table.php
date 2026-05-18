<?php

use App\Models\Solicitud;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $id_user = null;

    #[Computed]
    public function prestamos()
    {
        $user = $this->id_user ? User::find($this->id_user) : auth()->user();

        // return Solicitud_Equipo::query()
        //     ->join('solicituds', 'solicitud__equipos.id_solicitud', '=', 'solicituds.id')
        //     ->where('solicituds.estado', 'Autorizada')
        //     ->where('solicituds.fecha_prestamo', '>', now())
        //     ->join('users', 'solicituds.id_trabajador', '=', 'users.id')
        //     ->select('solicitud__equipos.*', 'users.name as nombre_trabajador', 'users.id as id_trabajador')
        //     ->orderBy('solicituds.fecha_prestamo', 'asc')
        //     ->when($user && $user->hasRole('trabajador'), function ($query) use ($user) {
        //         $query->where('solicituds.id_trabajador', $user->id);
        //     })
        //     ->paginate(4);
        return Solicitud::query()
            ->when($user && $user->hasRole('trabajador'), function ($query) use ($user) {
                $query->where('solicituds.id_trabajador', $user->id);
            })
            ->where('estado', 'Autorizada')
            ->whereNull('fecha_entrega')
            ->where('fecha_prestamo', '>=', now()->format('Y-m-d'))
            ->orderBy('fecha_prestamo', 'asc')
            ->join('users', 'solicituds.id_trabajador', '=', 'users.id')
            ->select('solicituds.*', 'users.name as nombre_trabajador')
            
            ->paginate(4);
    }
};
