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
    <div class="w-full h-full mt-10">
        <div class="grid auto-rows-min gap-4 grid-cols-1 place-items-center content-center
                        lg:grid-cols-2
                ">
            <div class="h-full w-[84%] relative rounded-xl shadow-xl flex-col ">
                    <div class="flex flex-row items-center gap-3 px-8 pt-10 justify-center">
                        <flux:icon name="package" class="w-10 h-10 text-black dark:text-hueso" />
                        <h1 class="text-2xl font-bold text-center">Prestamo en curso</h1>
                    </div>
                    @if($prestamo_en_curso)
                        <h2 class="text-lg  text-center mt-4">
                            <span class="font-semibold">
                                Motivo:
                            </span>
                            {{$prestamo_en_curso->motivo}}</h2>
                        <h2 class="text-lg text-center mt-4">
                            <span class="font-semibold">
                                Fecha de devolución:
                            </span>
                            {{$prestamo_en_curso->fecha_devolucion }}</h2>
                            <div class="align-middle w-max mt-6 mx-auto pb-6">
                                <x-componentes.boton-href 
                                    ruta="archivo.show" 
                                    texto="Ver" 
                                    icon="eye" 
                                    :id="$prestamo_en_curso->id" 
                                    color="azul_saturado" 
                                    />    
                            </div>
                    @else
                        <h2 class="text-lg  text-center mt-4">No tienes prestamos en curso</h2>
                    @endif
            </div>
            <div class="w-[84%] flex  justify-around">
                <livewire:componentes.card 
                    titulo='{{ $porcentaje_cumplimiento }}' 
                    descripcion='Tasa de cumplimiento'
                    icono='box' 
                    color_text='text-hueso' 
                    color_bg='bg-verde_mid'
                    />
                <livewire:componentes.card 
                    titulo='Faltan' 
                    descripcion='{{ $devoluciones_atrasadas }} devoluciones' 
                    icono='triangle-alert' 
                    color_bg='bg-amarillo_logo'
                    />
            </div>

        </div>
        <div class="grid auto-rows-min gap-4 grid-cols-1 place-items-center content-center
                lg:grid-cols-2
        ">
            <div class="h-full w-[84%] relative rounded-xl shadow-xl">
            <!-- Titulo de la tabla -->
                    <div class="flex flex-row justify-start items-center gap-3 px-8 pt-10">
                        <flux:icon name="package" class="w-10 h-10 text-black dark:text-hueso" />
                        <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem] dark:text-hueso"> Proximos Prestamos</span>
                    </div>
                                    
                    <div class="pt-3 px-10 pb-6" >
                        <livewire:dashboard.index.prestamos.table lazy/>
                    </div>
            </div>

            <div class="h-full w-[84%] relative shadow-xl rounded-xl ">
                <div class="flex flex-row justify-start items-center gap-3 px-8 pt-10">
                    <flux:icon name="clock-alert" class="w-9! h-9! text-black dark:text-hueso" />
                    <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem] dark:text-hueso"> Prestamos Atrasados</span>
                </div>
                                    
                <div class="pt-3 px-10 pb-6" >
                        <livewire:dashboard.index.devoluciones.table lazy/>
                </div>
            </div>
            
        </div>
    </div>
</div>