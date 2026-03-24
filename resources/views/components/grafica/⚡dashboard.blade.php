<?php

use Livewire\Component;
use App\Charts\Barras;
use ArielMejiaDev\LarapexCharts\BarChart;
use App\Models\Unidad_Equipo;
new class extends Component
{
    public function getChartProperty():BarChart
    {
        return app()->make(Barras::class, ['datos' => [$this->filter_unidad('Disponible'),$this->filter_unidad('Prestado'),$this->filter_unidad('Reservado'),$this->filter_unidad('En reparación')]])->build();
    }

    public function getChartCdnProperty(): string
    {
        return $this->chart->cdn();
    }
    public function filter_unidad($tipo):int{
        return Unidad_Equipo::where('estado','=',$tipo)->count();
    }
};
?>

<div wire:ignore>
    {!! $this->chart->container() !!}
</div>

@assets
<script src="{{ $this->chartCdn }}"></script>
@endassets

@script
{!! $this->chart->script() !!}
@endscript