
<?php

use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use App\Models\Unidad_Equipo;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed()]
    public function cant_mantenimiento()
    {
        return Unidad_Equipo::where('mantenimiento', true)->count();
    }

    #[Computed()]
    public function mas_deudas()
    {
        return Solicitud::whereNotNull('fecha_entrega')->
                    whereColumn('fecha_devolucion', '<', 'fecha_entrega')->
                    join('users', 'users.id', '=', 'solicituds.id_trabajador')->
                    select('users.name', DB::raw('count(*) as total'), 'users.id')->
                    groupBy('users.name', 'users.id')->orderByDesc('total')->limit(5)->
                    get();
    }

    #[Computed()]
    public function mas_solicitado()
    {
        return Solicitud_Equipo::join('unidad__equipos', 'solicitud__equipos.id_unidad_equipo', '=', 'unidad__equipos.id')->
                                join('equipos', 'unidad__equipos.id_equipo', '=', 'equipos.id')->
                                select('equipos.modelo', 'equipos.marca', DB::raw('count(*) as total'), 'equipos.id')->
                                groupBy('equipos.modelo', 'equipos.marca', 'equipos.id')->orderByDesc('total')->limit(5)->get();
    }

    #[Computed()]
    public function menos_solicitado()
    {
        return Solicitud_Equipo::join('unidad__equipos', 'solicitud__equipos.id_unidad_equipo', '=', 'unidad__equipos.id')->
                                join('equipos', 'unidad__equipos.id_equipo', '=', 'equipos.id')->
                                select('equipos.modelo', 'equipos.marca', DB::raw('count(*) as total'), 'equipos.id')->
                                groupBy('equipos.modelo', 'equipos.marca', 'equipos.id')->orderBy('total')->limit(5)->get();
    }
};
