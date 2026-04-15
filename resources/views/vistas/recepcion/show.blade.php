@php
    $prestamo = \App\Models\Solicitud::find(request()->route('id'));
@endphp
<x-layouts::app title="Mostrar Préstamo">
    <div class="px-4">
        {{-- navegacion interna --}}
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('recepcion.index') }}"><span class="!text-gris_claro">Recepción</span></flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#"><span class="!text-gris_claro">{{ $prestamo->motivo }}</span>    </flux:breadcrumbs.item>
            </flux:breadcrumbs>
    </div>
    {{-- div general --}}   
    <div class=" flex w-full h-[90%] items-center justify-around pt-2">
        
        {{-- div grande 1 --}}
       <section class="flex flex-col self-start pt-8 gap-18 w-[55%] h-full ">
                
        {{-- info de la vista --}}
            <div class="flex flex-col items-start justify-center gap-8 pl-3  ">               
                <x-componentes.titulo icono="book-marked" texto="Detalles de la solicitud" />
                <x-componentes.subtitulo icono="square-user-round" texto=" {{ __('Solicitud de:') }} {{ $prestamo->trabajador->name }}" />
            </div>

            <div class="bg-white rounded-lg shadow-md px-5 py-6.5 flex flex-col gap-2 ">
                
                <div class="inline-flex items-center text-gris_claro gap-2 ml-5">
                    <flux:icon.clipboard-paste class="size-8" />
                    <span class="font-bold text-2xl">Resumen de la solicitud</span>  
                </div>
                
                <div class="px-13 py-3 h-9/10">
                    <livewire:recepcion.show.table from="{{ $prestamo->fecha_prestamo }}" to="{{ $prestamo->fecha_devolucion }}" :solicitudId="$id" lazy/>
                </div>
            </div>

        </section> 

        {{-- div grande pt2 --}}
        <section class="w-[40%] h-full flex flex-col justify-start items-center gap-9.5 ">
            <div >
                <livewire:componentes.card titulo='4 Prestamos' descripcion='Pendientes de entrega' 
                icono='box' color_text='black'/>    
                
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