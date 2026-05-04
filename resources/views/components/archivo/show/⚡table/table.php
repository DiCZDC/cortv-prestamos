<?php

use Livewire\Component;
use App\Models\Solicitud_Equipo;
use App\Models\Solicitud;
use Livewire\Attributes\Computed;

new class extends Component
{
    public $solicitudId;

    #[Computed()]
    public function solicitud(){
        return Solicitud::find($this->solicitudId);
    }
    #[Computed()]
    public function detalles(){
        return Solicitud_Equipo::where('id_solicitud', $this->solicitudId)->get();
    }
};
