
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
       <section class="flex flex-col self-start pt-8 gap-19 w-[55%] h-full ">
                
        {{-- info de la vista --}}
            
        <div class="flex flex-col items-start justify-center gap-4 pt-1">               
                
            <div class="flex flex-col items-start justify-center gap-7 pl-3  ">               
                
                <x-componentes.titulo icono="book-marked" texto="Detalles de la recepción" />
                <x-componentes.subtitulo icono="square-user-round" texto=" {{ __('Solicitud de:') }} {{ $prestamo->trabajador->name }}" />
            </div> 
            <div class="pl-3 mt-2">
                <x-componentes.subtitulo icono="shield-user" texto=" {{ __('Autorizada por:') }} {{ $prestamo->admin->name }}" />
            </div>
        </div>

            <div class="bg-white rounded-lg shadow-md px-5 py-7 flex flex-col gap-3 ">
                
                <div class="inline-flex items-center text-gris_claro gap-3 ml-5">
                    <flux:icon.clipboard-paste class="size-10" />
                    <span class="font-medium text-3xl">Resumen de la solicitud</span>  
                </div>

                
                <div class="px-10 h-9/10 w-full ">
                    <livewire:recepcion.show.table from="{{ $prestamo->fecha_prestamo }}" to="{{ $prestamo->fecha_devolucion }}" :solicitudId="$id" lazy/>
                </div>
            </div>

        </section> 

        {{-- div grande pt2 --}}
        <section class="w-[40%] h-full flex flex-col justify-start items-center gap-14 pt-6 ">
            
            <div>
                <livewire:componentes.card 
                :titulo="$titulo" 
                :descripcion="$descripcion" 
                :icono="$icono"     
                color_bg='bg-hueso!'
                :color_text="$color_text"/>    
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