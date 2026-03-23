<?php

use Livewire\Component;
use App\Charts\Barras;

new class extends Component
{
    public function getChartProperty(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return app(Barras::class)->build();
    }

    public function getChartCdnProperty(): string
    {
        return $this->chart->cdn();
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