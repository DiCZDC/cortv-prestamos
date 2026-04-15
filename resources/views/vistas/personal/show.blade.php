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
                        <livewire:dashboard.index.prestamos.table :id_user='$id' lazy/>
                    </div>
            </div>

            <div class="h-full w-[84%] relative shadow-xl rounded-xl ">
                <div class="flex flex-row justify-start items-center gap-3 px-8 pt-10">
                    <flux:icon name="clock-alert" class="w-9! h-9! text-black dark:text-hueso" />
                    <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem] dark:text-hueso"> Prestamos Atrasados</span>
                </div>
                                    
                <div class="pt-3 px-10 pb-6" >
                        <livewire:dashboard.index.devoluciones.table :id_user='$id' lazy/>
                </div>
            </div>
        
        </div>
    </div>
</div>
