<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\{
    Solicitud_Equipo,
    Unidad_Equipo,
    Equipo
};

new class extends Component
{

    #[Computed()]
    public function mas_solicitado(){
        // return DB::table('solicitud__equipos')->join('unidad__equipos','solicitud__equipos.id_unidad_Equipo', '=','unidad__equipos.id')->join('equipos', 'unidad__equipos.id_equipo','=','equipos.id')->get();
        // return Solicitud_Equipo::join('unidad__equipos','solicitud__equipos.id_unidad_Equipo', '=','unidad__equipos.id')->join('equipos', 'unidad__equipos.id_equipo','=','equipos.id')->groupBy('equipos.modelo')->count();
        return Solicitud_Equipo::join('unidad__equipos','solicitud__equipos.id_unidad_Equipo', '=','unidad__equipos.id')->
                                join('equipos', 'unidad__equipos.id_equipo','=','equipos.id')->
                                select('equipos.modelo','equipos.marca', \DB::raw('count(*) as total'))->
                                groupBy('equipos.modelo','equipos.marca')->orderByDesc('total')->first();
    }
    #[Computed()]
    public function menos_solicitado(){
        return Solicitud_Equipo::join('unidad__equipos','solicitud__equipos.id_unidad_Equipo', '=','unidad__equipos.id')->
                                join('equipos', 'unidad__equipos.id_equipo','=','equipos.id')->
                                select('equipos.modelo','equipos.marca', \DB::raw('count(*) as total'))->
                                groupBy('equipos.modelo','equipos.marca')->orderBy('total')->first();
    }
};
