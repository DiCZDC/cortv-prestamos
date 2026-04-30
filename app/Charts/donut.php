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
            ->addData([$this->datos[0], $this->datos[1], $this->datos[2], $this->datos[3]])
            ->setLabels(['Mantenimiento', 'Disponibles', 'Prestados', 'Se entregan hoy'])
            ->setFontFamily('Instrument Sans, ui-sans-serif')
            ->setXAxis([' Equipos en total  '])
            ->setColors(['#279AF1', '#76D245', '#AE2B2F', '#EEC33B']);

        //  ,
    }
}
