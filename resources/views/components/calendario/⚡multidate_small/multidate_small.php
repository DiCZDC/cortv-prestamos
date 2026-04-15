<?php

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use Livewire\Attributes\Computed;
new class extends Component
{
    public $anio;
    public $mes;
    public $range = 3; // Rango de meses a mostrar antes y después del mes actual


    public function mount()
    {
        $this->anio = now()->year;
        $this->mes   = now()->month;
    }

    // #[Computed()]
    


    public function mesAnterior()
    {
        $minDate = now()->subMonths($this->range);
        if($minDate->month < $this->mes || $minDate->year < $this->anio) {
            $fecha = Carbon::createFromDate($this->anio, $this->mes, 1)->subMonth();
            $this->mes  = $fecha->month;
            $this->anio = $fecha->year;
        }
    }

    public function mesSiguiente()
    {
        $maxDate = now()->addMonths($this->range);
        if($maxDate->month > $this->mes || $maxDate->year > $this->anio) {
            $fecha = Carbon::createFromDate($this->anio, $this->mes, 1)->addMonth();
            $this->mes  = $fecha->month;
            $this->anio = $fecha->year;
        }
    }

    public function with(): array
    {
        $primerDia   = Carbon::createFromDate($this->anio, $this->mes, 1);
        $diasEnMes   = $primerDia->daysInMonth;
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
            'dias'      => $dias,
        ];
    }
};