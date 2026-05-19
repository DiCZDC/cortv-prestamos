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
            
            ->paginate(3);
    }
};
