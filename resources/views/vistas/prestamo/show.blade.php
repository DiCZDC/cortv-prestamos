@php
    $Solicitud = \App\Models\Solicitud::find($id);
@endphp

<x-layouts::app title="Mostrar Préstamo">
       
    {{-- div general --}}
    <div class="px-4">
        {{-- navegacion interna --}}
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('prestamo.index') }}"><span class="!text-gris_claro">Préstamos</span></flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#"><span class="!text-gris_claro">{{ $Solicitud->motivo. ' - ' . $Solicitud->fecha_prestamo }}</span>    </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="w-full flex py-8">
        {{-- div grande 1 --}}
       <section class="w-1/2 flex flex-col gap-10 ">
            {{-- info de la vista --}}
            <div class="flex flex-col items-start justify-center gap-8 pl-3 ">               
                <x-componentes.titulo icono="book-marked" texto="Detalles de la solicitud" />
                <x-componentes.subtitulo icono="airplay" texto=" {{ __('Solicitud para:') }} {{ $Solicitud->motivo }}" />
            </div>

            <div class="bg-white rounded-lg shadow-md px-5 py-6.5 justify-end ">
                <span class="font-bold text-2xl text-gris_claro ml-7">Resumen de la solicitud</span>  
                <div class="px-5 py-3 h-9/10">
                    <livewire:prestamo.show.table from="{{ $Solicitud->fecha_prestamo }}" to="{{ $Solicitud->fecha_devolucion }}" :solicitudId="$id" lazy/>
                </div>
               
            </div>

        </section> 

        {{-- div grande pt2 --}}
        <section class="w-1/2 flex flex-col items-center gap-15">
            <div class="-mt-8" >
                <livewire:componentes.card
                :titulo="'Asignar equipos'"
                :descripcion="'Selecciona los equipos que deseas asignar a esta solicitud'"
                :icono="'thumbs-up'"
                :color_bg="'bg-verde_mid'"
                :color_text="'text-hueso'"
               />
            </div>

            <div class="flex flex-col items-center justify-start gap-10 py-1 ">
                <div>
                    <span class="font-bold text-3xl text-black">Periodo de préstamo</span>
                </div>
                
                <livewire:calendario.small :id="$id"/>
                                
            </div>

        </section>
        </div>

    </div>
    
</x-layouts::app >
