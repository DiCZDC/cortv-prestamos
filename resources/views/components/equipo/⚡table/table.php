<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\{
    Equipo,
    Unidad_Equipo
};
new class extends Component
{
    use WithPagination;
    public $sortBy = 'id';
    public $sortDirection = 'ASC';
    public $search = '';
    public $perPage = 10;

    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }
    
    public function cant_equipos($id)
    {
        return Unidad_Equipo::where('id_equipo', $id)->where('estado', 'Disponible')->count();
    }
    
    #[Computed]
    public function equipos()
    {
        return Equipo::query()
            ->tap(fn($query)=> $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate($this->perPage);
    }
};