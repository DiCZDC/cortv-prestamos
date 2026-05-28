<?php
use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Unidad_Equipo;
use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;

new class extends Component
{
    public $fecha_actual;

    public function mount(): void
    {
        $this->fecha_actual = now()->format('d-m-Y');
    }

    #[Computed]
    public function chartData(): array
    {
        return [
            Unidad_Equipo::where('mantenimiento', true)->count(),
            Unidad_Equipo::where('mantenimiento', false)->count() - $this->equipos_prestados() - $this->entrega_hoy(),
            $this->equipos_prestados(),
            $this->entrega_hoy(),
        ];
    }

    #[Computed]
    public function equipos_prestados()
    {
        $prestados = Solicitud::whereIn('estado', ['Entregada', 'Autorizada'])
            ->where('fecha_prestamo', '<', now())
            ->where('fecha_devolucion', '>=', now())
            ->pluck('id');

        return Solicitud_Equipo::whereIn('id_solicitud', $prestados)->count();
    }

    #[Computed]
    public function entrega_hoy()
    {
        $solicitudes = Solicitud::whereIn('estado', ['Entregada', 'Autorizada'])
            ->where('fecha_prestamo', now())->pluck('id');

        return Solicitud_Equipo::whereIn('id_solicitud', $solicitudes)
            ->join('unidad__equipos', 'solicitud__equipos.id_unidad_equipo', '=', 'unidad__equipos.id')
            ->select('solicitud__equipos.*', 'unidad__equipos.mantenimiento')
            ->where('unidad__equipos.mantenimiento', false)
            ->count();
    }
};
?>

<div wire:ignore class="rounded-2xl py-7 px-9 w-full bg-hueso shadow-xl dark:bg-zinc-900">
    <span class="font-semibold text-black text-2xl dark:text-hueso">
        Estado de los equipos hoy {{ $fecha_actual }}
    </span>
    <canvas id="donut-chart" class="mt-4 max-h-72"></canvas>
</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

@script
<script>
    const isDark = document.documentElement.classList.contains('dark');
    const labelColor = isDark ? '#f5f5f4' : '#18181b';
    const legendPosition = (width) => {
        if (width < 640) return 'bottom';   // sm
        if (width < 1024) return 'right';   // lg
        return 'right';
    };
    new Chart(document.getElementById('donut-chart'), {
        type: 'doughnut',
        data: {
            labels: ['Mantenimiento', 'Disponibles', 'Prestados', 'Se entregan hoy'],
            datasets: [{
                data: @json($this->chartData),
                backgroundColor: ['#279AF1', '#76D245', '#AE2B2F', '#EEC33B'],
                borderWidth: 0,
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: legendPosition(window.innerWidth),
                    labels: { color: labelColor, font: { family: 'Instrument Sans, ui-sans-serif' } },
                },
                tooltip: {
                    titleColor: labelColor,
                    bodyColor: labelColor,
                },
            },
        },
    });
</script>
@endscript
