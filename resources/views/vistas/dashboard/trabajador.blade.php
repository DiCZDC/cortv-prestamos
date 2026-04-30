@php
    $solicitudes = App\Models\Solicitud::where('id_trabajador', auth()->user()->id)->get();
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
    $prestamo_en_curso = App\Models\Solicitud::where('id_trabajador', auth()->user()->id)
                            ->where('estado','Autorizada')
                            ->first();

@endphp
<div class="h-full  overflow-hidden ">
    <div class=" ml-15 pt-2 w-3/4 gap-6">
        {{-- Cabecera principal --}}
        <div class="mb-4 flex items-center gap-6 text-rojo_claro">
            <flux:icon name="home" class="inline h-15 w-15" />
            <span class="ml-2 text-5xl font-semibold">
                {{ __('Inicio') }}
            </span>
        </div>
        <div class="mb-2 flex items-center text-gris_claro  align-middle gap-7
                dark:text-hueso    
        ">
            <flux:icon name="user" class="inline h-10 w-10" />
            <span class="text-[30px] -tracking-tighter text-gris_claro dark:text-hueso font-inter" style="font-style: normal;">
                {{ __('Bienvenid@ de vuelta :name', ['name' => auth()->user()->name]) }}
            </span>
        </div>
    </div>
    <div class="mt-8">
        <livewire:personal.show.data :id="auth()->user()->id" />
    </div>
</div>