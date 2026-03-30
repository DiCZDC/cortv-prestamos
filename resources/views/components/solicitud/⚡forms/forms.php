<?php
use Flux\Flux;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Equipo;
use App\Models\Unidad_Equipo;
use Livewire\Attributes\On;

new class extends Component
{   
    #[Validate('required', message: 'Ingrese un motivo de préstamo')]
    #[Validate('min:10', message: 'El motivo es demasiado corto')]
    #[Validate('required|max:255', message: 'El motivo es demasiado largo')] 
    public $motivo;

    #[Validate('required', message: 'Seleccione una fecha de inicio del préstamo')]
    public $fecha_prestamo;
    
    public $estado = 'Pendiente';
    
    #[Validate('required', message: 'Seleccione una fecha de devolución')]
    public $fecha_devolucion;
    
    #[Validate('required', message: 'Seleccione al menos un equipo para el préstamo')]
    public $equipos_seleccionados = [];

    #[On('equipo-agregado')]
    public function agregar_equipo($unidad_id)
    {
        // Evitar duplicados con IDs simples
        if (!in_array($unidad_id, $this->equipos_seleccionados)) {
            $this->equipos_seleccionados[] = $unidad_id;
        }
    }

    public function eliminar_equipo($id)
    {
        $this->equipos_seleccionados = array_values(
            array_filter($this->equipos_seleccionados, fn($item) => $item != $id)
        );

    }

    #[Computed]
    public function unidades_seleccionadas()
    {
        return Unidad_Equipo::with('equipo')
            ->whereIn('id', $this->equipos_seleccionados)
            ->get();
    }

    public function save() {
        $this->validate();

    }
};