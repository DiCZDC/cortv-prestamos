<?php

use Livewire\Component;
use App\Models\Unidad_Equipo;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;
    public $id;

    #[Computed]
    public function productos()
    {
        return Unidad_Equipo::where('id_equipo', $this->id)->paginate(10);
    }
};