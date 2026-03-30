<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Equipo;
use App\Models\Unidad_Equipo;

new class extends Component
{
    public $motivo;

    public $fecha_prestamo;

    public $estado = 'Pendiente';

    public $fecha_devolucion;
    
    // modelo + equipo
    public $nombre_equipo =1; 

    public $nombre_unidad_equipo;

    #[Computed]
    public function equipos()
    {
        return Equipo::all();
    }

    #[Computed]
    public function unidades_equipo($id){
        return Unidad_Equipo::where('id_equipo', $id)->get();
    }
};
