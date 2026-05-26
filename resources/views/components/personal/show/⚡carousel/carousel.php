<?php

use Livewire\Component;
use App\Models\Solicitud;
use Livewire\Attributes\Computed;

new class extends Component
{
    public $id;

    #[Computed()]
    public function prestamo_en_curso()
    {
        $solicitud =Solicitud::where('id_trabajador', $this->id)
            ->where('estado', 'Entregada')
            ->first();
        
        if (!$solicitud) return null;
        $data = [
            'titulo' => 'Prestamo en curso',
            'subtitulo' => $solicitud ? $solicitud->motivo : null,
            'date' => $solicitud ? $solicitud->fecha_devolucion : null,
            'pill' => $solicitud ? round(now()->diffInDays($solicitud->fecha_devolucion, false)) . ' dias restantes' : null,
            'route' => $solicitud ? $solicitud->id : null,
        ];

        return $data;
    }
    #[Computed()]
    public function ultimo_prestamo()
    {
        $solicitud = Solicitud::where('id_trabajador', $this->id)
            ->where('estado', 'Devuelta')
            ->latest()
            ->first();
        if (!$solicitud) return null;
        $data = [
            'titulo' => 'Ultimo prestamo',
            'subtitulo' => $solicitud ? $solicitud->motivo : null,
            'date' => $solicitud ? $solicitud->fecha_devolucion : null,
            'pill' => $solicitud ? $solicitud->estado : null,
            'route' => $solicitud ? $solicitud->id : null,
        ];

        return $data;
    }
    #[Computed()]
    public function ultima_solicitud()
    {
        $solicitud = Solicitud::where('id_trabajador', $this->id)
            ->latest()
            ->first();
        if(!$solicitud) return null;
        $data = [
            'titulo' => 'Ultima solicitud',
            'subtitulo' => $solicitud ? $solicitud->motivo : null,
            'date' => $solicitud ? $solicitud->fecha_devolucion : null,
            'pill' => $solicitud ? $solicitud->estado : null,
            'route' => $solicitud ? $solicitud->id : null,
        ];

        return $data;
    }
    #[Computed()]
    public function historial_prestamos()
    {
        $array = [
            $this->prestamo_en_curso,
            $this->ultimo_prestamo,
            $this->ultima_solicitud,
        ];

        return array_filter($array, fn ($item) => $item !== null);
    }
};  
