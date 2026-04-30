@php
    $user = App\Models\User::findOrFail($id);
    $prestamo_en_curso = App\Models\Solicitud::where('id_trabajador', $id)
                            ->where('estado','Autorizada')
                            ->first();
    $solicitudes = App\Models\Solicitud::where('id_trabajador', $id)->get();

    $devoluciones_totales = $solicitudes
                            ->where('estado','Devuelta')
                            ->count();
    $devoluciones_en_tiempo = $solicitudes
                            ->filter(function ($solicitud) {
                                return $solicitud->estado === 'Devuelta'
                                    && \Illuminate\Support\Carbon::parse($solicitud->fecha_devolucion)
                                        ->lt(\Illuminate\Support\Carbon::parse($solicitud->fecha_entrega));
                            })
                            ->count();
    $porcentaje_cumplimiento =  
                $solicitudes->count() != 0 ?
                number_format($devoluciones_totales > 0 ? (($devoluciones_totales-$devoluciones_en_tiempo )/ $devoluciones_totales) * 100 : 0, 2).'%'
                :'Sin préstamos'
                ;
    $devoluciones_atrasadas = $solicitudes
                            ->filter(function ($solicitud) {
                                return $solicitud->estado === 'Entregada'
                                    && \Illuminate\Support\Carbon::parse($solicitud->fecha_devolucion)->lt(now());
                            })
                            ->count();

@endphp
<x-layouts::app title="Personal">
    <!-- An unexamined life is not worth living. - Socrates -->
    <div class="px-4">
        {{-- navegacion interna --}}
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('personal.index') }}"><span class="!text-gris_claro">Personal</span></flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#"><span class="!text-gris_claro">{{ $user->name }}</span>    </flux:breadcrumbs.item>
            </flux:breadcrumbs>
    
        <div class="flex flex-col justify-center gap-8.5 pl-3 mt-10 mb-6 ">
            <x-componentes.titulo icono="id-card-lanyard" texto="Usuario" />
            <x-componentes.subtitulo icono="user" texto="{{ $user->name }}" />
        </div>
        

        <livewire:personal.show.data :id="$id" />
</div>
