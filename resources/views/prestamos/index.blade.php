<x-layouts::app :title="__('Prestamos Pendientes')">
    {{-- div general --}}
    <div class="px-1 ">
        {{-- header --}}
        <div class="flex w-full pr-5 justify-between mb-4 ">
            {{-- info de la vista --}}
            <div class="flex flex-col justify-center gap-8.5 pl-3 ">
                <div class="flex items-center gap-3 text-rojo_claro">
                    <flux:icon name="file" class="inline size-13" />
                    <h1 class="text-5xl font-bold inline">Prestamos</h1>
                </div>
                <div class="flex items-center gap-3 text-gris_claro pl-1.5">
                    <flux:icon name="book-alert" class="inline size-9" />
                    <span class="text-2xl text-gris_claro font-semibold " >
                        {{ __('Solicitudes de prestamos pendientes de aprobar') }}
                    </span>
                </div>
            </div>
            {{-- card --}}
            
            <div>
                <livewire:card titulo='4 Prestamos' descripcion='Pendientes de entrega' icono='box' color_text='black'/>    
            </div>
        
        
        </div>

        {{-- tabla --}}
        <div class="w-full not-dark:bg-white rounded-lg not-dark:shadow-md  p-8">
            {{-- filtros de busqueda --}}
            <div>
                
            </div> 

            @livewire('prestamos.table')            
        </div>

        {{-- boton  --}}
        <div class="flex w-full justify-end mt-4 pr-1">
            <x-componentes.boton-href ruta="prestamos.create" texto="Crear nuevo prestamo" icon="square-plus" color="rojo_claro" />
        </div>
    </div>
</x-layouts::app>
