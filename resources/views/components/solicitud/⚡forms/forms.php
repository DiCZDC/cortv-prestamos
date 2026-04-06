<?php
use Flux\Flux;
use Livewire\Attributes\Validate;
use App\Models\Equipo;
use App\Models\Unidad_Equipo;
use App\Models\Solicitud;

use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

new class extends Component
{   
    #[Validate('required', message: 'Ingrese un motivo de préstamo')]
    #[Validate('min:10', message: 'El motivo es demasiado corto')]
    #[Validate('max:255', message: 'El motivo es demasiado largo')] 
    public $motivo;

    #[Validate('required', message: 'Seleccione una fecha de inicio del préstamo')]
    public $fecha_prestamo;
    
    public $estado = 'Pendiente';
    
    #[Validate('required', message: 'Seleccione una fecha de devolución')]
    public $fecha_devolucion;
    
    #[Validate('required', message: 'Seleccione al menos un equipo para el préstamo')]
    #[Validate('array')]
    #[Validate('min:1', message: 'Debe seleccionar al menos un equipo para el préstamo')]
    public $equipos_seleccionados = [];

    #[Validate('required',message: 'Seleccione un trabajador para el préstamo')]  
    public $trabajador;

    #[On('equipo-agregado')]
    public function agregar_equipo($unidad_id)
    {
        // Evitar duplicados con IDs simples
        if (!in_array($unidad_id, $this->equipos_seleccionados)) {
            $this->equipos_seleccionados[] = $unidad_id;
            Flux::toast(
                heading: 'Equipo agregado',
                text: 'El equipo ha sido agregado a la solicitud correctamente.',
                variant: 'success',
            );
        }

        else {
            Flux::toast(
                heading: 'Equipo ya seleccionado',
                text: 'El equipo que intentas agregar ya ha sido seleccionado.',
                variant: 'warning',
            );
        }

    }

    // funcion maestra no tocar
    public function save() {
        $this->validate();
        $usuario = Auth::user(); 
        if ($usuario->hasRole('admin')) {
            $this->guardarAdmin();
        } else {
            $this->guardarTrabajador();
        }
    }

    public function guardarAdmin(){
        try {
            DB::transaction(function () {

                $solicitud = Solicitud::create([
                    'id_trabajador' => $this->trabajador,
                    'id_admin'      => Auth::user()->id,
                    'motivo'        => $this->motivo,
                    'estado'        => 'Autorizada',
                    'fecha_prestamo'   => $this->fecha_prestamo,
                    'fecha_devolucion' => $this->fecha_devolucion,
                ]);

            foreach ($this->equipos_seleccionados as $unidad_id) {

                $unidad = Unidad_Equipo::lockForUpdate()->find($unidad_id);

                if (!$unidad || $unidad->estado !== 'disponible') {
                    throw new \Exception(
                        "La unidad con SICIPO '{$unidad->sicipo}' ya no está disponible."
                    );
                    Flux::toast(
                        heading: 'Error al crear solicitud',
                        text: 'El equipo que intentas agregar ya ha sido seleccionado.',
                        variant: 'warning',
                    );
                }

                $solicitud->unidades()->attach($unidad_id);
                $unidad->update(['estado' => 'Prestado']);
            }

        }, attempts: 3);

        Flux::toast(heading: 'Solicitud autorizada', variant: 'success');
        $this->reset(['motivo', 'fecha_prestamo', 'fecha_devolucion', 
                      'equipos_seleccionados', 'trabajador']);

    } catch (\Exception $e) {
        Flux::toast(heading: 'Error', text: $e->getMessage(), variant: 'danger');
    }
    }

    public function guardarTrabajador(){
        try {
        DB::transaction(function () {

            // 1. Crear la solicitud
            $solicitud = Solicitud::create([
                'id_trabajador' => Auth::user()->id,
                'motivo'        => $this->motivo,
                'estado'        => 'Pendiente',
                'fecha_prestamo'   => $this->fecha_prestamo,
                'fecha_devolucion' => $this->fecha_devolucion,
            ]);

            // 2. Por cada unidad seleccionada
            foreach ($this->equipos_seleccionados as $unidad_id) {

                // 3. Bloquear la fila de unidad_equipo (aquí está el estado mutable)
                $unidad = Unidad_Equipo::lockForUpdate()->find($unidad_id);

                // 4. Verificar que sigue disponible (otro usuario pudo tomarla)
                if (!$unidad || $unidad->estado !== 'disponible') {
                    throw new \Exception(
                        "La unidad con SICIPO '{$unidad->sicipo}' ya no está disponible."
                    );
                }

                // 5. Crear el registro en solicitud__equipos
                $solicitud->unidades()->attach($unidad_id);

                // 6. Actualizar estado de la unidad
                $unidad->update(['estado' => 'Prestado']);
            }

        }, attempts: 3);

        Flux::toast(
            heading: 'Solicitud enviada',
            text: 'Tu solicitud de préstamo fue registrada correctamente.',
            variant: 'success',
        );

        // Limpiar formulario
        $this->reset(['motivo', 'fecha_prestamo', 'fecha_devolucion', 'equipos_seleccionados']);

    } catch (\Exception $e) {
        Flux::toast(
            heading: 'Error al crear solicitud',
            text: $e->getMessage(),
            variant: 'danger',
        );
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

    #[Computed]
    public function trabajadores()
    {
        return User::role('trabajador')->with('roles')->get();
    }

    
};