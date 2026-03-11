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
            ->tap(fn($query)=> $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }
};
