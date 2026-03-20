<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use app\Models\{
    Solicitud_Equipo,
    Equipo,
    User
};

new class extends Component
{
    use WithPagination;
    public $dias = 2;
    
    #[Computed]
    public function prestamos()
    {
        return Solicitud_Equipo::query()
            
            ->paginate(5);
    }    
};
