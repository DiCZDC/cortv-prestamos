<?php

use App\Models\Solicitud_Equipo;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
new class extends Component
{
    use WithPagination;
    public $id_user = null;
    #[Computed]
    public function prestamos()
    {
        $user = $this->id_user ? User::find($this->id_user) : auth()->user();
        return Solicitud_Equipo::query()
            ->join('solicituds', 'solicitud__equipos.id_solicitud', '=', 'solicituds.id')
            ->where('solicituds.estado', 'Autorizada')
            ->where('solicituds.fecha_prestamo', '>', now())
            ->join('users', 'solicituds.id_trabajador', '=', 'users.id')
            ->select('solicitud__equipos.*', 'users.name as nombre_trabajador','users.id as id_trabajador')
            ->orderBy('solicituds.fecha_prestamo', 'asc')
            ->when($user && $user->hasRole('trabajador'), function ($query) use ($user) {
                $query->where('solicituds.id_trabajador', $user->id);
            })
            ->paginate(5);
    }
};
