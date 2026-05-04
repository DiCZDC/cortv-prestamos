<?php

use App\Models\Solicitud;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $sortBy = 'fecha_devolucion';

    public $sortDirection = 'ASC';

    public $search = '';

    public $perPage = 6;

    public $filter = '';

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[On('searchUpdated')]
    public function updateSearch($value)
    {
        $this->search = $value;
    }

    #[On('filterUpdated')]
    public function updateFilter($value)
    {
        $this->filter = $value;
    }

    #[Computed]
    public function prestamos()
    {
        return Solicitud::query()
            ->where('estado', 'Entregada')
            ->whereNull('fecha_entrega')
            ->when($this->filter !== '', function ($query) {
                if ($this->filter == 'atrasado') {
                    $query->whereDate('fecha_devolucion', '<', now()->toDateString());
                } elseif ($this->filter == 'tiempo') {
                    $query->whereDate('fecha_devolucion', '>=', now()->toDateString());
                }
                // dd($this->filter);
            })
            ->orderBy("solicituds.{$this->sortBy}", $this->sortDirection)
            ->join('users', 'solicituds.id_trabajador', '=', 'users.id')
            ->select('solicituds.*', 'users.name as nombre_trabajador')
            ->join('users as admin', 'solicituds.id_admin', '=', 'admin.id')
            ->select('solicituds.*', 'users.name as nombre_trabajador', 'admin.name as nombre_admin')
            ->when($this->search !== '', function ($query) {
                $query
                    ->whereRaw('LOWER(users.name) like ?', ['%'.strtolower($this->search).'%'])
                    ->orWhereRaw('LOWER(admin.name) like ?', ['%'.strtolower($this->search).'%'])
                    ->orWhereRaw('LOWER(solicituds.motivo) like ?', ['%'.strtolower($this->search).'%']);
            })
            ->paginate($this->perPage);
    }
};
