<?php

use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use App\Models\Unidad_Equipo;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $id;

    public function toggleMantenimiento($id_producto)
    {
        $producto = Unidad_Equipo::find($id_producto);
        if ($producto) {
            $producto->mantenimiento = ! $producto->mantenimiento;
            $producto->save();
        }
    }

    #[Computed]
    public function equipos_prestados()
    {
        $prestados = Solicitud::whereIn('estado', ['Entregada'])
            ->where('fecha_prestamo', '<=', now())
            ->where('fecha_devolucion', '>=', now())
            ->pluck('id');

        return Solicitud_Equipo::whereIn('id_solicitud', $prestados)
            ->pluck('id_unidad_equipo')
            ->unique();
    }

    #[Computed]
    public function productos()
    {
        return Unidad_Equipo::where('id_equipo', $this->id)
            ->orderBy('id', 'asc')
            ->paginate(10);
    }
};
