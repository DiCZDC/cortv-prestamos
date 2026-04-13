<?php
use Flux\Flux;
use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use App\Models\Unidad_Equipo;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component
{

    public $from;
    public $to;

    public $solicitudId;

    public $valido = true; 

    public function mount($solicitudId)
    {
        $solicitud = Solicitud::findOrFail($solicitudId);
    }
    #[Computed]
    public function solicitudInfo()
    {
        return Solicitud::findOrFail($this->solicitudId);
    }
    #[Computed]
    public function detalles()
    {
        return Solicitud_Equipo::where('id_solicitud', $this->solicitudId)->get();
    }

    #[Computed]
    public function solicitud($id_equipo)
    {
        $hoy = now()->toDateString();

        $total = Solicitud::join('solicitud__equipos', 'solicituds.id', '=', 'solicitud__equipos.id_solicitud')
            ->join('unidad__equipos', 'unidad__equipos.id', '=', 'solicitud__equipos.id_unidad_equipo')
            ->where('solicituds.estado', 'Autorizada')
            ->where('unidad__equipos.id', $id_equipo)
            ->whereRaw('? BETWEEN solicituds.fecha_prestamo AND solicituds.fecha_entrega', [$hoy])
            ->distinct('solicituds.id')
            ->count('solicituds.id');

        return $total == 0 ? true : false;
    }
    
    #[Computed]
    public function equipos_ocupados(){
        if (empty($this->from) || empty($this->to)) {
            return collect();
        }

        $prestados_1 = Solicitud::whereIn('estado',['Entregada','Autorizada'])->whereBetween('fecha_prestamo', [$this->from,$this->to])->pluck('id');
        $prestados_2 = Solicitud::whereIn('estado',['Entregada','Autorizada'])->whereBetween('fecha_devolucion', [$this->from,$this->to])->pluck('id');
        $prestados_3 = Solicitud::whereIn('estado',['Autorizada','Entregada'])->where('fecha_prestamo','<',$this->from)->where('fecha_devolucion','>',$this->to)->pluck('id');
        $prestados = $prestados_1->merge($prestados_2)->merge($prestados_3)->unique();

        return Solicitud_Equipo::whereIn('id_solicitud', $prestados)
            ->pluck('id_unidad_equipo')
            ->unique();
    }

    public function equipos_libres($id){
        return Unidad_Equipo::where('id_equipo', $id)
            ->whereNotIn('id', $this->equipos_ocupados())
            ->get();
    }
 
    public function actualizar(){
        $solicitud = Solicitud::findOrFail($this->solicitudId);
        $id_admin = Auth::user()->id;
        
        $solicitud->update([
            'estado'      => 'Autorizada',
            'id_admin' => $id_admin,
        ]);

        Flux::toast(
            heading: 'Solicitud aprobada',
            text: 'La solicitud de préstamo de ' . $solicitud->trabajador->name . ' fue aprobada correctamente.',
            variant: 'success',
        );
    }

};
