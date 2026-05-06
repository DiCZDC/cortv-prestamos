<?php

use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $solicitudId;

    #[Computed()]
    public function solicitud()
    {
        return Solicitud::find($this->solicitudId);
    }

    #[Computed()]
    public function detalles()
    {
        return Solicitud_Equipo::where('id_solicitud', $this->solicitudId)->get();
    }
};
