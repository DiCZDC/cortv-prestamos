<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\{
    Solicitud,
    Solicitud_Equipo,
    Unidad_Equipo,
    Equipo
};

new class extends Component
{
    #[Computed()]
    public function cant_mantenimiento(){
        return Unidad_Equipo::where('estado','=','En reparación')->count();
    }
    #[Computed()]
    public function mas_deudas(){
        return Solicitud::whereNotNull('fecha_entrega')->
                    whereColumn('fecha_devolucion', '<', 'fecha_entrega')->
                    join('users','users.id', '=','solicituds.id_trabajador')->
                    select('users.name', \DB::raw('count(*) as total'))->
                    groupBy('users.name')->orderByDesc('total')->limit(5)->
                    get();
    }

    #[Computed()]
    public function mas_solicitado(){
        return Solicitud_Equipo::join('unidad__equipos','solicitud__equipos.id_unidad_Equipo', '=','unidad__equipos.id')->
                                join('equipos', 'unidad__equipos.id_equipo','=','equipos.id')->
                                select('equipos.modelo','equipos.marca', \DB::raw('count(*) as total'))->
                                groupBy('equipos.modelo','equipos.marca')->orderByDesc('total')->limit(5)->get();
    }
    #[Computed()]
    public function menos_solicitado(){
        return Solicitud_Equipo::join('unidad__equipos','solicitud__equipos.id_unidad_Equipo', '=','unidad__equipos.id')->
                                join('equipos', 'unidad__equipos.id_equipo','=','equipos.id')->
                                select('equipos.modelo','equipos.marca', \DB::raw('count(*) as total'))->
                                groupBy('equipos.modelo','equipos.marca')->orderBy('total')->limit(5)->get();
    }
};
