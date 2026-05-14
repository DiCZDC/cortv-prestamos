<?php

use App\Models\Solicitud_Equipo;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $id_equipo;
    public $anio;
    public $mes;

    public $range = 3; // Rango de meses a mostrar antes y después del mes actual

    public function mount()
    {
        $this->anio = now()->year;
        $this->mes = now()->month;
    }

    #[Computed()]
    public function fechasApartadas()
    {
        $inicio = Carbon::createFromDate(now()->subMonths($this->range)->year, now()->subMonths($this->range)->month, 1)->startOfMonth();
        $fin = Carbon::createFromDate(now()->addMonths($this->range)->year, now()->addMonths($this->range)->month, 1)->endOfMonth();

        return Solicitud_Equipo::query()
            ->join('solicituds', 'solicitud__equipos.id_solicitud', '=', 'solicituds.id')
            ->where('solicituds.estado', 'Autorizada')
            ->join('unidad__equipos', 'solicitud__equipos.id_unidad_equipo', '=', 'unidad__equipos.id')
            ->where('unidad__equipos.id', $this->id_equipo)
            ->whereBetween('solicituds.fecha_prestamo', [$inicio, $fin])
            ->select('solicituds.fecha_prestamo', DB::raw('COUNT(solicitud__equipos.id) as total_equipos'))
            ->groupBy('solicituds.fecha_prestamo')
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->fecha_prestamo)->format('Y-m-d');
            });
    }

    public function createDate($dia, $mes, $anio)
    {
        return Carbon::createFromDate($anio, $mes, $dia)->toDateString();

    }

    public function mesAnterior()
    {
        $minDate = now()->subMonths($this->range);
        if ($minDate->month < $this->mes || $minDate->year < $this->anio) {
            $fecha = Carbon::createFromDate($this->anio, $this->mes, 1)->subMonth();
            $this->mes = $fecha->month;
            $this->anio = $fecha->year;
        }
    }

    public function mesSiguiente()
    {
        $maxDate = now()->addMonths($this->range);
        if ($maxDate->month > $this->mes || $maxDate->year > $this->anio) {
            $fecha = Carbon::createFromDate($this->anio, $this->mes, 1)->addMonth();
            $this->mes = $fecha->month;
            $this->anio = $fecha->year;
        }
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
