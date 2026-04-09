<?php

use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use App\Models\Unidad_Equipo;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
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
            DB::transaction(function () {

                $solicitud = Solicitud::create([
                    'id_trabajador' => $this->trabajador,
                    'id_admin' => Auth::user()->id,
                    'motivo' => $this->motivo,
                    'estado' => 'Autorizada',
                    'fecha_prestamo' => $this->fecha_prestamo,
                    'fecha_devolucion' => $this->fecha_devolucion,
                ]);

                foreach ($this->equipos_seleccionados as $unidad_id) {

                    $unidad = Unidad_Equipo::lockForUpdate()->find($unidad_id);

                    // $solicitud->unidades()->attach($unidad_id);
                    Solicitud_Equipo::create([
                        'id_solicitud' => $solicitud->id,
                        'id_unidad_equipo' => $unidad_id,
                    ]);

                }

            }, attempts: 3);

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
            DB::transaction(function () {

                // 1. Crear la solicitud
                $solicitud = Solicitud::create([
                    'id_trabajador' => Auth::user()->id,
                    'id_admin' => null,
                    'motivo' => $this->motivo,
                    'estado' => 'Pendiente',
                    'fecha_prestamo' => $this->fecha_prestamo,
                    'fecha_devolucion' => $this->fecha_devolucion,
                ]);

                // 2. Por cada unidad seleccionada
                foreach ($this->equipos_seleccionados as $unidad_id) {

                    // 3. Bloquear la fila de unidad_equipo (aquí está el estado mutable)
                    $unidad = Unidad_Equipo::lockForUpdate()->find($unidad_id);

                    // 5. Crear el registro en solicitud__equipos
                    Solicitud_Equipo::create([
                        'id_solicitud' => $solicitud->id,
                        'id_unidad_equipo' => $unidad_id,
                    ]);

                }

            }, attempts: 3);

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
