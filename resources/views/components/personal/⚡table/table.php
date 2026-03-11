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
        return User::query()->paginate(10);
    }

};
