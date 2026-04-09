@php
    $Solicitud = \App\Models\Solicitud::find($id);
@endphp

<x-layouts::app title="Mostrar Préstamo">
       
    {{-- div general --}}
    <div class="px-1">
        {{-- navegacion interna --}}
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('prestamo.index') }}"><span class="!text-gris_claro">Préstamos</span></flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#"><span class="!text-gris_claro">{{ $Solicitud->motivo. ' - ' . $Solicitud->fecha_prestamo }}</span>    </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        {{-- header --}}
        <div class="flex w-full pr-5 mb-3 mt-7 
            md:flex-row md:gap-8">
            {{-- info de la vista --}}
            <div class="flex flex-col justify-center gap-8 pl-3 ">               
                <x-componentes.titulo icono="book-marked" texto="Detalles de la solicitud" />
                <x-componentes.subtitulo icono="airplay" texto=" {{ __('Solicitud para:') }} {{ $Solicitud->motivo }}" />
            </div>        
        </div>

        {{-- cuerpo del chow   --}}
        <section class="flex gap-12 px-5 mt-10">
            
            <div class="bg-white rounded-lg shadow-md p-8 w-1/2">
                <span class="font-bold text-xl text-gris_claro ml-7">Resumen de la solicitud</span>  
                <div class="px-7 py-5">
                    <livewire:prestamo.show.table :solicitudId="$id" lazy/>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8 w-1/2">
                
            </div>
        
        </section>


    </div>
    
</x-layouts::app >
