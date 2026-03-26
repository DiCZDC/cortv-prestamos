<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\BarChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class Prueba
{
    protected $chart;

    public $datos = [0, 0, 0, 0];

    public function __construct(LarapexChart $chart, array $datos = [])
    {
        $this->chart = $chart;
        if (! empty($datos)) {
            $this->datos = $datos;
        }
    }

    public function build(): BarChart
    {
        return $this->chart->barChart()
            ->setTitle('Productos disponibles.')
            ->setSubtitle('Estado actual del inventario.')
            ->addData([$this->datos[0]], 'Disponibles')
            ->addData([$this->datos[1]], 'Prestados')
            ->addData([$this->datos[2]], 'Reservados')
            ->addData([$this->datos[3]], 'En mantenimiento')
            ->setXAxis([' Equipos en total  '])
            ->setGrid(color: '#6C757D', opacity: 0.1, strokeDashArray: 7)
            ->setShowXAxisLabels(false);
    }
}
