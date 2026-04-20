<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\DonutChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class donut
{
    protected $chart;

    public $datos = [0, 0, 0];

    public function __construct(LarapexChart $chart, array $datos)
    {
        $this->chart = $chart;
        $this->datos = $datos;
    }

    public function build(): DonutChart
    {
        return $this->chart->donutChart()
            ->setSubtitle('Estado del inventario hoy.')
            ->addData([$this->datos[0], $this->datos[1], $this->datos[2], $this->datos[3]])
            ->setLabels(['Mantenimiento', 'Disponibles', 'Prestados', 'Se entregan hoy'])
            ->setXAxis([' Equipos en total  '])
            ->setColors(['#76D245', '#AE2B2F', '#279AF1', '#EEC33B']);
        //  ,
    }
}
