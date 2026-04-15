<?php

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
            $producto->mantenimiento = !$producto->mantenimiento;
            $producto->save();
        }
    }
    #[Computed]
    public function productos()
    {
        return Unidad_Equipo::where('id_equipo', $this->id)
            ->orderBy('id', 'asc')
            ->paginate(10);
    }
};
