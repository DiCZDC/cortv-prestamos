<?php

use App\Models\Solicitud;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $userId;

    public $sortBy = 'id';

    public $sortDirection = 'asc';

    public function mount()
    {
        $this->userId = auth()->id();
    }

    public function sort($column)
    {
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
        return Solicitud::query()->where('id_trabajador', $this->userId)
            ->orderBy("solicituds.{$this->sortBy}", $this->sortDirection)
            ->join('users', 'solicituds.id_admin', '=', 'users.id')
            ->paginate(10);
        // ->tap(fn($query)=> $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
    }
};
/*
        Solicitud::query()->where('id_trabajador', 1)
            ->orderBy("solicituds.id", 'asc')
            ->join('users', 'solicituds.id_admin', '=', 'users.id')
            ->paginate(10);
 */
