<?php

use Livewire\{
    Component,
    WithPagination
    };
use Livewire\Attributes\Computed;
use App\Models\{
    Solicitud,
    User
};

new class extends Component
{

    use WithPagination;
    public $sortBy = 'id';
    public $sortDirection = 'ASC';
    public $search = '';
    public $perPage = 6;

    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function prestamos()
    {
        return Solicitud::query()
            ->where('estado','Pendiente')
            ->whereNull('fecha_entrega')
            ->orderBy("solicituds.{$this->sortBy}", $this->sortDirection)
            ->join('users', 'solicituds.id_trabajador', '=', 'users.id')
            ->select('solicituds.*', 'users.name as nombre_trabajador')
            ->paginate($this->perPage);
    }
};
