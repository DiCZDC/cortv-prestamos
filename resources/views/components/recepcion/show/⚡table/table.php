<?php

use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use App\Models\Unidad_Equipo;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $solicitudId;

    public array $mantenimiento = [];

    public function mount($solicitudId)
    {
        Solicitud::findOrFail($solicitudId);
        $this->solicitudId = $solicitudId;

    }

    #[Computed]
    public function solicitudInfo()
    {
        return Solicitud::findOrFail($this->solicitudId);
    }

    #[Computed]
    public function detalles()
    {
        return Solicitud_Equipo::where('id_solicitud', $this->solicitudId)->get();
    }

    public function recibir()
    {
        $idsSeleccionadas = collect($this->mantenimiento)
            ->filter(fn ($checked) => (bool) $checked)
            ->keys()
            ->map(fn ($id) => (int) $id)
            ->all();

        // Seguridad: solo IDs que realmente pertenecen a esta solicitud
        $idsValidas = $this->detalles()
            ->pluck('id_unidad_equipo')
            ->map(fn ($id) => (int) $id)
            ->all();

        $idsSeleccionadas = array_values(array_intersect($idsSeleccionadas, $idsValidas));

        if (! empty($idsSeleccionadas)) {
            Unidad_Equipo::whereIn('id', $idsSeleccionadas)->update([
                'mantenimiento' => true,
            ]);
        }

        Solicitud::whereKey($this->solicitudId)->update([
            'estado' => 'Devuelta',
            'fecha_entrega' => now()->toDateString(),
        ]);

        Flux::toast(
            heading: 'Recepción correcta',
            text: 'El equipo de la solicitud de préstamo de '.$this->solicitudInfo()->trabajador->name.' fue recibida correctamente.',
            variant: 'success',
        );
    }
};
