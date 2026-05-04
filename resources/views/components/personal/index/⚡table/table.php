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

    #[On('searchUpdated')]
    public function updateSearch($value)
    {
        $this->search = $value;
    }
    #[On('ActualizarPadre')]
    public function actualizar(){
        $this->dispatch('$refresh');
    }
    #[Computed]
    public function personal()
    {
        return User::with('roles')
            ->when($this->search !== '', function ($query) {
                $query->whereRaw('LOWER(users.name) like ?', ['%'.strtolower($this->search).'%'])
                    ->orWhereRaw('LOWER(users.email) like ?', ['%'.strtolower($this->search).'%']);
                // ->orWhereRaw('LOWER(solicituds.motivo) like ?', ['%' . strtolower($this->search) . '%']);
            })
            ->paginate(8);
    }

    // User::whereHas('roles', function ($query) {    $query->where('name', 'admin');})->get();
};
