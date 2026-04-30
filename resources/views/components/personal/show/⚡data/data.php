<?php

use Livewire\Component;
use App\Models\User;
use App\Models\Solicitud;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
new class extends Component
{

    public $id;

    #[Computed()]
    public function user(){
        return User::findOrFail($id);
    }
    #[Computed()]
    public function prestamo_en_curso()
    {
        return Solicitud::where('id_trabajador', $this->id)
                            ->where('estado','Autorizada')
                            ->first();
    }
    #[Computed()]   
    public function solicitudes(){
        return Solicitud::where('id_trabajador', $this->id)->get();
    }
    #[Computed()]   
    public function devoluciones_totales(){
        return $this->solicitudes()
                            ->where('estado','Devuelta')
                            ->count();
    }
    #[Computed()]   
    public function devoluciones_en_tiempo(){
        return $this->solicitudes()
                            ->filter(function ($solicitud) {
                                return $solicitud->estado === 'Devuelta'
                                    && Carbon::parse($solicitud->fecha_devolucion)
                                        ->lt(Carbon::parse($solicitud->fecha_entrega));
                            })
                            ->count();
    }
    #[Computed()]   
    public function porcentaje_cumplimiento(){
        $devoluciones_totales = $this->devoluciones_totales();
        $devoluciones_en_tiempo = $this->devoluciones_en_tiempo();
        return $this->solicitudes()->count() != 0 ?
            number_format($devoluciones_totales > 0 ? (($devoluciones_totales-$devoluciones_en_tiempo )/ $devoluciones_totales) * 100 : 0, 2).'%'
            :'Sin préstamos'
            ;
    }
    #[Computed()]   
    public function devoluciones_atrasadas(){
        return $this->solicitudes()
                            ->filter(function ($solicitud) {
                                return $solicitud->estado === 'Entregada'
                                    && Carbon::parse($solicitud->fecha_devolucion)->lt(Carbon::now());
                            })
                            ->count();
    }   
    // $devoluciones_totales = $solicitudes
    //                         ->where('estado','Devuelta')
    //                         ->count();
    // $devoluciones_en_tiempo = $solicitudes
    //                         ->filter(function ($solicitud) {
    //                             return $solicitud->estado === 'Devuelta'
    //                                 && Carbon::parse($solicitud->fecha_devolucion)
    //                                     ->lt(Carbon::parse($solicitud->fecha_entrega));
    //                         })
    //                         ->count();
    // $porcentaje_cumplimiento =  
    //             $solicitudes->count() != 0 ?
    //             number_format($devoluciones_totales > 0 ? (($devoluciones_totales-$devoluciones_en_tiempo )/ $devoluciones_totales) * 100 : 0, 2).'%'
    //             :'Sin préstamos'
    //             ;
    // $devoluciones_atrasadas = $solicitudes
    //                         ->filter(function ($solicitud) {
    //                             return $solicitud->estado === 'Entregada'
    //                                 && Carbon::parse($solicitud->fecha_devolucion)->lt(Carbon::now());
    //                         })
    //                         ->count();
};