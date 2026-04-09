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
        return Solicitud::query()->where('id_trabajador', auth()->id())
            ->orderBy("solicituds.{$this->sortBy}", $this->sortDirection)
            ->join('users', 'solicituds.id_admin', '=', 'users.id')
            ->select('solicituds.*', 'users.name as admin_name')
            ->paginate(10);
    }
};
