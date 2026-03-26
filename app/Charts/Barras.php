<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\BarChart;

class Barras
{
    protected $chart;

    public $datos = [0,0,0,0];

    public function __construct(LarapexChart $chart, array $datos)
    {
        $this->chart = $chart;
        $this->datos = $datos;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return $this->chart->barChart()
            ->setTitle('Productos disponibles.')
            ->setSubtitle('Estado actual del inventario.')
            ->addData([$this->datos[0]], 'Disponibles')
            ->addData([$this->datos[1]], 'Prestados')
            ->addData([$this->datos[2]], 'Reservados')
            ->addData([$this->datos[3]], 'En mantenimiento')
            ->setXAxis([' Equipos en total  ' ])
            ->setColors(['#76D245', '#AE2B2F', '#279AF1', '#EEC33B'])
            ->setGrid(color: '#6C757D', opacity: 0.1, strokeDashArray: 7);
            
    }
}
