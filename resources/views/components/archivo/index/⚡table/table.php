<?php

use App\Models\Solicitud;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $sortBy = 'id';

    public $sortDirection = 'ASC';

    public $search = '';

    public $filter = '';

    public $perPage = 10;

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
        $user = auth()->user();
        return Solicitud::query()
            ->orderBy("solicituds.{$this->sortBy}", $this->sortDirection)
            ->join('users as trabajador', 'solicituds.id_trabajador', '=', 'trabajador.id')
            ->select('solicituds.*', 'trabajador.name as nombre_trabajador')
            ->join('users as admin', 'solicituds.id_admin', '=', 'admin.id')
            ->select('solicituds.*', 'trabajador.name as nombre_trabajador', 'admin.name as nombre_admin')
            ->where('solicituds.estado', '!=', 'Pendiente')
            ->when($user && $user->hasRole('trabajador'), function ($query) use ($user) {
                $query->where('solicituds.id_trabajador', $user->id);
            })
            ->when($this->search !== '', function ($query) {
                $query->whereRaw('LOWER(admin.name) like ?', ['%'.strtolower($this->search).'%'])
                    ->orWhereRaw('LOWER(trabajador.name) like ?', ['%'.strtolower($this->search).'%'])
                    ->orWhereRaw('LOWER(solicituds.motivo) like ?', ['%'.strtolower($this->search).'%']);
            })
            ->when($this->filter !== '', function ($query) {
                $query->where('solicituds.estado', $this->filter);
            })
            ->paginate($this->perPage);
    }
};
