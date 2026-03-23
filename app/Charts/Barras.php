<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class Barras
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return $this->chart->barChart()
            ->setTitle('San Francisco vs Boston.')
            ->setSubtitle('Wins during season 2021.')
            ->addData([6], 'Dispobivles')
            ->addData([10], 'Prestados')
            ->addData([2], 'Reservados')
            ->addData([2], 'En mantenimiento')
            ->setXAxis([' Equipos en total  ' ])
            ->setGrid(color: '#6C757D', opacity: 0.1, strokeDashArray: 7)
            ->setShowXAxisLabels(false);
    }
}
