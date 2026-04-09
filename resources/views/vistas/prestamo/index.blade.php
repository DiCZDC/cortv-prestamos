<x-layouts::app :title="__('Prestamos Pendientes')">
    {{-- div general --}}
    <div class="px-1 ">
        {{-- header --}}
        <div class="flex w-full pr-5 justify-between mb-4 
            gap-10 items-center flex-col-reverse
            md:flex-row md:gap-8.5
        ">
            {{-- info de la vista --}}
            <div class="flex flex-col justify-center gap-8.5 pl-3 ">
                
                <x-componentes.titulo icono="file" texto="Prestamos" />
                <x-componentes.subtitulo icono="book-alert" texto="Prestamos pendientes de aprobar" />

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

            <livewire:prestamo.table lazy />
        </div>

        {{-- boton  --}}
        <div class="flex w-full justify-end mt-4 pr-1">
            <x-componentes.boton-href ruta="prestamo.create" texto="Crear nuevo prestamo" icon="square-plus" color="rojo_claro" />
        </div>
    </div>
</x-layouts::app>
