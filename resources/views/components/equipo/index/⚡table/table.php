<?php

use App\Models\Equipo;
use App\Models\Unidad_Equipo;
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

    public $filter;

    public $perPage = 10;

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

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function cant_equipos($id)
    {
        return Unidad_Equipo::where('id_equipo', $id)->count();
    }

    #[Computed]
    public function equipos()
    {
        return Equipo::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->join('categorias', 'equipos.id_categoria', '=', 'categorias.id')
            ->select('equipos.*', 'categorias.nombre_categoria', 'categorias.icono as icono_categoria')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereRaw('LOWER(equipos.modelo) like ?', ['%'.strtolower($this->search).'%'])
                        ->orWhereRaw('LOWER(equipos.marca) like ?', ['%'.strtolower($this->search).'%']);
                });
            })
            ->when($this->filter, function ($query) {
                $query->where('categorias.id', '=', $this->filter);
            })
            ->paginate($this->perPage);
    }
};
