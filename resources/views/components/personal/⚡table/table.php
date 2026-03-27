<?php

use App\Models\User;
use Livewire\Attributes\Computed;
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

    #[Computed]
    public function personal()
    {
        return User::
            with('roles')
            ->when($this->search !== '', function ($query) {
                $query->whereRaw('LOWER(users.name) like ?', ['%' . strtolower($this->search) . '%'])
                    ->orWhereRaw('LOWER(users.email) like ?', ['%' . strtolower($this->search) . '%']);
                    // ->orWhereRaw('LOWER(solicituds.motivo) like ?', ['%' . strtolower($this->search) . '%']);
            })
            ->paginate(10);
    }

    // User::whereHas('roles', function ($query) {    $query->where('name', 'admin');})->get();
};
