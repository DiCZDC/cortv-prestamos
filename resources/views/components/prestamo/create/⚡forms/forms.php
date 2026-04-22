<?php

use App\Http\Controllers\PrestamoController;
use App\Models\Unidad_Equipo;
use App\Models\User;
use Flux\Flux;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public $motivo;

    public $fecha_prestamo;

    public $estado = 'Pendiente';

    public $fecha_devolucion;

    public $equipos_seleccionados = [];

    public $trabajador = null;

    public function rules()
    {
        $rules = [
            'motivo' => ['required', 'min:10', 'max:255'],
            'fecha_prestamo' => ['required'],
            'fecha_devolucion' => ['required'],
            'equipos_seleccionados' => ['required', 'array', 'min:1'],
        ];

        // Condición dinâmica: Solo si es admin agregamos la regla para el trabajador
        if (Auth::user()->hasRole('admin')) {
            $rules['trabajador'] = ['required', 'exists:users,id'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'motivo.required' => 'Ingrese un motivo de préstamo',
            'motivo.min' => 'El motivo es demasiado corto',
            'motivo.max' => 'El motivo es demasiado largo',
            'fecha_prestamo.required' => 'Seleccione una fecha de inicio del préstamo',
            'fecha_devolucion.required' => 'Seleccione una fecha de devolución',
            'equipos_seleccionados.required' => 'Seleccione al menos un equipo para el préstamo',
            'equipos_seleccionados.min' => 'Debe seleccionar al menos un equipo para el préstamo',
            'trabajador.required' => 'Seleccione un trabajador para el préstamo',
            'trabajador.exists' => 'El trabajador seleccionado no es válido',
        ];
    }

    #[On('equipo-agregado')]
    public function agregar_equipo($unidad_id)
    {
        // Evitar duplicados con IDs simples
        if (! in_array($unidad_id, $this->equipos_seleccionados)) {
            $this->equipos_seleccionados[] = $unidad_id;
            Flux::toast(
                heading: 'Equipo agregado',
                text: 'El equipo ha sido agregado a la solicitud correctamente.',
                variant: 'success',
            );
        } else {
            Flux::toast(
                heading: 'Equipo ya seleccionado',
                text: 'El equipo que intentas agregar ya ha sido seleccionado.',
                variant: 'warning',
            );
        }

    }

    // funcion maestra no tocar
    public function save()
    {
        $usuario = Auth::user();

        // Esto evaluará automáticamente TODAS las reglas definidas en rules()
        $this->validate();
        if ($usuario->hasRole('admin')) {
            $this->guardarAdmin();

            return;
        }

        $this->guardarTrabajador();
    }

    public function guardarAdmin()
    {
        try {
            app(PrestamoController::class)->store(new Request([
                'motivo' => $this->motivo,
                'fecha_prestamo' => $this->fecha_prestamo,
                'fecha_devolucion' => $this->fecha_devolucion,
                'equipos_seleccionados' => $this->equipos_seleccionados,
                'trabajador' => $this->trabajador,
                'estado' => 'Autorizada',
            ]));

            Flux::toast(
                heading: 'Solicitud creada y autorizada',
                text: 'La solicitud ha sido creada y autorizada correctamente.',
                variant: 'success',
            );
            $this->reset(['motivo', 'fecha_prestamo', 'fecha_devolucion',
                'equipos_seleccionados', 'trabajador']);

        } catch (Exception $e) {
            Flux::toast(heading: 'Error', text: $e->getMessage(), variant: 'danger');
        }
    }

    public function guardarTrabajador()
    {
        try {

            app(PrestamoController::class)->store(new Request([
                'motivo' => $this->motivo,
                'fecha_prestamo' => $this->fecha_prestamo,
                'fecha_devolucion' => $this->fecha_devolucion,
                'equipos_seleccionados' => $this->equipos_seleccionados,
                'trabajador' => Auth::user()->id,
                'estado' => 'Pendiente',
            ]));

            Flux::toast(
                heading: 'Solicitud enviada',
                text: 'Tu solicitud de préstamo fue registrada correctamente.',
                variant: 'success',
            );

            // Limpiar formulario
            $this->reset(['motivo', 'fecha_prestamo', 'fecha_devolucion', 'equipos_seleccionados']);

        } catch (Exception $e) {
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
            array_filter($this->equipos_seleccionados, fn ($item) => $item != $id)
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
