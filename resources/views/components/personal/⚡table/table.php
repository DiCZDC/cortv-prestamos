<?php

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

new class extends Component{
    use WithPagination;

    #[Computed]
    public function personal()
    {
        return User::with('roles')->paginate(10);
    }


    //User::whereHas('roles', function ($query) {    $query->where('name', 'admin');})->get();
};

