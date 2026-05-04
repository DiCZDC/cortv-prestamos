<?php

use Livewire\Component;
use App\Models\Solicitud_Equipo;

new class extends Component
{
    public $solicitudId;

    public function detalles(){
        return Solicitud_Equipo::where('id_solicitud', $this->solicitudId)->get();
    }    
};
