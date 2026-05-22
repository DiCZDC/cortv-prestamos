<?php

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 6;

    public $filter = '';

    public $sortBy = 'rol';

    public $sortDirection = 'DESC';

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

    #[On('ActualizarPadre')]
    public function actualizar()
    {
        $this->dispatch('$refresh');
    }

    #[Computed]
    public function personal()
    {
        return User::with('roles')
            ->select('users.*')

            ->leftJoin('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.model_type', User::class);
            })
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->whereRaw('LOWER(users.name) like ?', ['%'.strtolower($this->search).'%'])
                        ->orWhereRaw('LOWER(users.email) like ?', ['%'.strtolower($this->search).'%']);
                });
            })
            ->when($this->filter !== '', function ($query) {
                if ($this->filter == 'admin') {
                    $query->where('roles.name', 'admin');
                } elseif ($this->filter == 'trabajador') {
                    $query->where('roles.name', 'trabajador');
                }
            })
            // Condicionar el orderBy: si la columna es 'rol', ordenamos por roles.name
            ->when($this->sortBy === 'rol', function ($query) {
                $query->orderBy('roles.name', $this->sortDirection);
            }, function ($query) {
                $query->orderBy("users.{$this->sortBy}", $this->sortDirection);
            })
            ->paginate($this->perPage);
    }
};
