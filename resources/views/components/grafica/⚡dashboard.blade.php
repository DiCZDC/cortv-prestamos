<?php
use Livewire\Component;
use App\Charts\donut;
use ArielMejiaDev\LarapexCharts\DonutChart;
use Livewire\Attributes\Computed;
use App\Models\Equipo;
use App\Models\Unidad_Equipo;
use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;

new class extends Component
{
    public $fecha_actual;

    public function mount(): void
    {
        $this->fecha_actual = now()->format('d-m-Y');
    }

    public function getChartProperty():DonutChart
    {
        return app()->make(donut::class, ['datos' => [
            Unidad_Equipo::where('mantenimiento',true)->count(),
            Unidad_Equipo::where('mantenimiento',false)->count() - $this->equipos_prestados() - $this->entrega_hoy(),
            $this->equipos_prestados(),
            $this->entrega_hoy()
        ]])->build();
    }

    public function getChartCdnProperty(): string
    {
        return $this->chart->cdn();
    }

    #[Computed]
    public function equipos_prestados(){

        $prestados = Solicitud::whereIn('estado', ['Entregada', 'Autorizada'])
            ->where('fecha_prestamo', '<', now())
            ->where('fecha_devolucion', '>=', now())
            ->pluck('id');

        return Solicitud_Equipo::whereIn('id_solicitud', $prestados)
            ->count();
    }
    #[Computed]
    public function entrega_hoy()
    {
        $solicitudes = Solicitud::whereIn('estado', ['Entregada', 'Autorizada'])
            ->where('fecha_prestamo', now())->pluck('id');
        
        return Solicitud_Equipo::whereIn('id_solicitud', $solicitudes)
                    ->join('unidad__equipos', 'solicitud__equipos.id_unidad_equipo', '=', 'unidad__equipos.id')
                    ->select('solicitud__equipos.*','unidad__equipos.mantenimiento')
                    ->where('unidad__equipos.mantenimiento', false)
            ->count();
    }

};
?>

<div wire:ignore class="rounded-2xl py-7 px-9 w-full  bg-hueso shadow-xl">
    <span class="font-semibold text-black text-2xl  dark:text-hueso">
        Estado de los equipos hoy  {{ $fecha_actual }} 
    </span>
    {!! $this->chart->container() !!}
</div>

@assets
<script src="{{ $this->chartCdn }}"></script>
@endassets

@script
{!! $this->chart->script() !!}
@endscript