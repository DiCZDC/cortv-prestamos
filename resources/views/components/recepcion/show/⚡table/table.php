<?php

use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use App\Models\Unidad_Equipo;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $from;

    public $to;

    public $solicitudId;

    public array $mantenimiento = [];


    public function mount($solicitudId)
    {
        Solicitud::findOrFail($solicitudId);
        $this->solicitudId = $solicitudId;

        $detalles = Solicitud_Equipo::where('id_solicitud', $this->solicitudId)
            ->with('unidad_equipo')
            ->get();

        foreach ($detalles as $detalle) {
            $idUnidad = (string) $detalle->id_unidad_equipo;
            $this->mantenimiento[$idUnidad] = (bool) $detalle->unidad_equipo->mantenimiento;
        }

    }

    #[Computed]
    public function solicitudInfo()
    {
        return Solicitud::findOrFail($this->solicitudId);
    }

    #[Computed]
    public function detalles()
    {
        return Solicitud_Equipo::where('id_solicitud', $this->solicitudId) ->get();
    }
    
    public function recibir()
    {
        DB::transaction(function () {
            foreach ($this->detalles() as $detalle) {
                $idUnidad = (string) $detalle->id_unidad_equipo;

                Unidad_Equipo::whereKey($idUnidad)->update([
                    'mantenimiento' => (bool) ($this->mantenimientos[$idUnidad] ?? false),
                    // 'estado' => (bool) ($this->mantenimientos[$idUnidad] ?? false) ? 'En mantenimiento' : 'Disponible',
                ]);
            }

            Solicitud::whereKey($this->solicitudId)->update([
                'estado' => 'Devuelta',
                'fecha_entrega' => '2026-04-19',
            ]);
        });

        $solicitud = Solicitud::findOrFail($this->solicitudId);

        Flux::toast(
            heading: 'Recepción aprobada',
            text: 'El equipo de la solicitud de préstamo de '.$solicitud->trabajador->name.' fue recibida correctamente.',
            variant: 'success',
        );
    }
    
};
