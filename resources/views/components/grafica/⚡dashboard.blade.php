<?php

use Livewire\Component;
use App\Charts\donut;
use ArielMejiaDev\LarapexCharts\DonutChart;
use App\Models\Unidad_Equipo;
new class extends Component
{
    public function getChartProperty():DonutChart
    {
        return app()->make(donut::class, ['datos' => [
            Unidad_Equipo::where('mantenimiento',true)->count(),
            Unidad_Equipo::where('mantenimiento',false)->count(),

        ]])->build();
    }

    public function getChartCdnProperty(): string
    {
        return $this->chart->cdn();
    }
};
?>

<div wire:ignore class="rounded-2xl">
    {!! $this->chart->container() !!}
</div>

@assets
<script src="{{ $this->chartCdn }}"></script>
@endassets

@script
{!! $this->chart->script() !!}
@endscript