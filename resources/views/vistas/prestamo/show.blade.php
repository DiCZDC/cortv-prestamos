@php
    $Solicitud = \App\Models\Solicitud::find($id);
    $totalSolicitudes = \App\Models\Solicitud::where('id_trabajador', $Solicitud->id_trabajador)->count();

    $entregadasEnTiempo = \App\Models\Solicitud::where('id_trabajador', $Solicitud->id_trabajador)
    ->whereNotNull('fecha_entrega')
    ->whereColumn('fecha_entrega', '<=', 'fecha_devolucion')
    ->count();

    $porcentajeCumplimiento = $totalSolicitudes > 0
    ? round(($entregadasEnTiempo * 100) / $totalSolicitudes, 1)
    : 0.0;

    $cumple = $porcentajeCumplimiento >= 70;

    $tituloCard = 'Cumplimiento del solicitante';
    $descripcionCard = $cumple
    ? 'El solicitante cumple en tiempo y forma'
    : 'El solicitante no cumple en tiempo y forma';
    $iconoCard = $cumple ? 'thumbs-up' : 'thumbs-down';
    $colorBgCard = $cumple ? 'bg-verde_mid' : 'bg-rojo_claro';
@endphp

<x-layouts::app title="Mostrar Préstamo">
    
    <div class = "px-9.5">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('prestamo.index') }}"><span class="!text-gris_claro">Préstamos</span></flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#"><span class="!text-gris_claro">{{ $Solicitud->motivo. ' - ' . $Solicitud->fecha_prestamo }}</span>    </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    
    {{-- div general --}}   
    <div class=" flex w-full h-[90%] items-center justify-around pt-2
        flex-col gap-10
        md:flex-row md:gap-0

    ">
        
        {{-- div grande 1 --}}
       <section class="flex flex-col self-start pt-8 gap-18 h-full 
            w-full md:w-[55%]
       ">
                
        {{-- info de la vista --}}
            <div class="flex flex-col items-start justify-center gap-8 pl-3  ">               
                <x-componentes.titulo icono="book-marked" texto="Detalles de la solicitud" />
                <x-componentes.subtitulo icono="square-user-round" texto=" {{ __('Solicitud de:') }} {{ $Solicitud->trabajador->name }}" />
            </div>

            <div class="bg-white rounded-lg shadow-md px-5 py-6.5 flex flex-col gap-2 dark:bg-transparent ">
                
                <div class="inline-flex items-center text-gris_claro gap-2 ml-5 ">
                    <flux:icon.clipboard-paste class="size-8" />
                    <span class="font-bold 
                    text-xl
                    md:text-2xl">Resumen de la solicitud</span>  
                </div>
                
                <div class="px-5 py-3 h-9/10">
                    <livewire:prestamo.show.table from="{{ $Solicitud->fecha_prestamo }}" to="{{ $Solicitud->fecha_devolucion }}" :solicitudId="$id" lazy/>
                </div>
            </div>

        </section> 

        {{-- div grande pt2 --}}
        <section class="w-[40%] h-full flex flex-col justify-start items-center gap-9.5 ">
            <div >
                <livewire:componentes.card
                    :titulo="$tituloCard"
                    :descripcion="$descripcionCard . ' (' . $porcentajeCumplimiento . '%)'"
                    :icono="$iconoCard"
                    :color_bg="$colorBgCard"
                    :color_text="'text-hueso'"
                    />
            </div>

            <div class="flex flex-col items-center justify-start gap-10 py-1 ">
                <div>
                    <span class="font-bold 
                    text-black text-2xl
                    
                    dark:text-hueso
                    md:text-3xl 
                    ">Periodo de préstamo</span>
                </div>
                
                <livewire:calendario.small :id="$id"/>
                                
            </div>

        </section>
        </div>

    </div>
    
</x-layouts::app >
