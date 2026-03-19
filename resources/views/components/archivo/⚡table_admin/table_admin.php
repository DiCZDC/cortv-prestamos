<?php

use Livewire\{
    Component,
    WithPagination
    };
use Livewire\Attributes\Computed;
use App\Models\Solicitud;

new class extends Component
{

    use WithPagination;
    public $sortBy = 'id';
    public $sortDirection = 'ASC';

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
            ->whereNotNull('fecha_entrega')
            ->orderBy("solicituds.{$this->sortBy}", $this->sortDirection)
            ->join('users', 'solicituds.id_trabajador', '=', 'users.id')
            ->select('solicituds.*', 'users.name as nombre_trabajador')
            ->join('users as admin', 'solicituds.id_admin', '=', 'admin.id')
            ->select('solicituds.*', 'users.name as nombre_trabajador', 'admin.name as nombre_admin')
            // ->tap(fn($query)=> $this->sortBy
            // ->join('users', 'solicituds.id_admin', '=', 'users.id')
            // ->tap(fn($query)=> $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }
};
