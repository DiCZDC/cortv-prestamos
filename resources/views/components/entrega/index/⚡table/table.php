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

    public $perPage = 8;

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

    #[Computed]
    public function prestamos()
    {
        return Solicitud::query()
            ->where('estado', 'Autorizada')
            ->whereNull('fecha_entrega')
            ->orderBy("solicituds.{$this->sortBy}", $this->sortDirection)
            ->join('users', 'solicituds.id_trabajador', '=', 'users.id')
            ->select('solicituds.*', 'users.name as nombre_trabajador')
            ->when($this->search !== '', function ($query) {
                $query->whereRaw('LOWER(users.name) like ?', ['%'.strtolower($this->search).'%'])
                    ->orWhereRaw('LOWER(solicituds.motivo) like ?', ['%'.strtolower($this->search).'%']);
            })
            ->paginate($this->perPage);
    }
};
