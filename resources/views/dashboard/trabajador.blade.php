@php

    $devoluciones_totales = App\Models\Solicitud::where('id_trabajador', auth()->user()->id)
                            ->where('estado','Devuelta')
                            ->count();
    $devoluciones_en_tiempo = App\Models\Solicitud::where('id_trabajador', auth()->user()->id)
                            ->where('estado','Devuelta')
                            ->whereColumn('fecha_devolucion','<=','fecha_entrega')
                            ->count();
    $porcentaje_cumplimiento = $devoluciones_totales > 0 ? ($devoluciones_en_tiempo / $devoluciones_totales) * 100 : 0; // Ejemplo de porcentaje de cumplimiento

    $devoluciones_atrasadas = App\Models\Solicitud::where('id_trabajador', auth()->user()->id)
                            ->where('estado','Entregada')
                            ->where('fecha_devolucion','<',now())
                            ->count();

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
            <div class="h-full w-[84%] relative rounded-xl shadow-xl">
                    Prestamo en curso
            </div>
            <div class="w-[84%] flex  justify-around">
                <livewire:card 
                    titulo='{{number_format($porcentaje_cumplimiento, 2)}}%' 
                    descripcion='Tasa de cumplimiento'
                    icono='box' 
                    color_text='text-hueso' 
                    color_bg='bg-verde_mid'
                    />
                <livewire:card 
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
                        <livewire:proximos_prestamos.tabla lazy/>
                    </div>
            </div>

            <div class="h-full w-[84%] relative shadow-xl rounded-xl ">
                <div class="flex flex-row justify-start items-center gap-3 px-8 pt-10">
                    <flux:icon name="clock-alert" class="w-9! h-9! text-black dark:text-hueso" />
                    <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem] dark:text-hueso"> Prestamos Atrasados</span>
                </div>
                                    
                <div class="pt-3 px-10 pb-6" >
                        <livewire:prestamos_atrasados.tabla lazy/>
                </div>
            </div>
            
        </div>
    </div>
</div>