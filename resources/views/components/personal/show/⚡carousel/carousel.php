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
        
        $data = [
            'titulo' => 'Prestamo en curso',
            'subtitulo' => $solicitud ? $solicitud->motivo : '',
            'date' => $solicitud ? $solicitud->fecha_devolucion : '',
            'pill' => $solicitud ? round(now()->diffInDays($solicitud->fecha_devolucion, false)) . ' dias restantes' : '',
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
        
        $data = [
            'titulo' => 'Ultimo prestamo',
            'subtitulo' => $solicitud ? $solicitud->motivo : '',
            'date' => $solicitud ? $solicitud->fecha_devolucion : '',
            'pill' => $solicitud->estado,
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
        
        $data = [
            'titulo' => 'Ultima solicitud',
            'subtitulo' => $solicitud ? $solicitud->motivo : '',
            'date' => $solicitud ? $solicitud->fecha_devolucion : '',
            'pill' => $solicitud->estado,
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
        return $array;
    }
};  
