<?php

use App\Models\Solicitud;
use Carbon\Carbon;
use Livewire\Component;

new class extends Component
{
    public $id;

    public int $mes;

    public int $anio;

    #[Computed()]
    public function solicitud()
    {
        return Solicitud::find($this->id);
    }

    public function mount($id)
    {
        $this->id = $id;

        $solicitud = Solicitud::findOrFail($id);
        $fechaPrestamo = $solicitud?->fecha_prestamo
        ? Carbon::parse($solicitud->fecha_prestamo)
        : now();

        $this->mes = $fechaPrestamo->month;
        $this->anio = $fechaPrestamo->year;
    }

    public function mesAnterior()
    {
        $fecha = Carbon::createFromDate($this->anio, $this->mes, 1)->subMonth();
        $this->mes = $fecha->month;
        $this->anio = $fecha->year;
    }

    public function mesSiguiente()
    {
        $fecha = Carbon::createFromDate($this->anio, $this->mes, 1)->addMonth();
        $this->mes = $fecha->month;
        $this->anio = $fecha->year;
    }

    public function with(): array
    {
        $primerDia = Carbon::createFromDate($this->anio, $this->mes, 1);
        $diasEnMes = $primerDia->daysInMonth;
        $inicioSemana = $primerDia->dayOfWeek; // 0=Dom

        $dias = [];

        // Espacios vacíos al inicio
        for ($i = 0; $i < $inicioSemana; $i++) {
            $dias[] = null;
        }

        for ($d = 1; $d <= $diasEnMes; $d++) {
            $dias[] = $d;
        }

        return [
            'nombreMes' => $primerDia->locale('es')->translatedFormat('F'),
            'dias' => $dias,
        ];
    }
};
