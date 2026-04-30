<x-layouts::app :title="__('Prestamos Pendientes')">
    {{-- div general --}}
    <div class="px-2 py-3.5 flex flex-col gap-3">
        {{-- header --}}
        <div class="flex w-full pr-5 justify-between mb-4 
            gap-10 items-center flex-col-reverse
            md:flex-row md:gap-8.5
        ">
            {{-- info de la vista --}}
            <div class="flex flex-col justify-center gap-6 pl-3 w-full">
                
                <x-componentes.titulo icono="file" texto="Prestamos" />
                
                <div class="flex w-full justify-between pr-5 ">
                        <x-componentes.subtitulo icono="book-alert" texto="Prestamos pendientes de aprobar" />
                        <x-componentes.boton-href ruta="prestamo.create" texto="Crear nuevo prestamo" icon="square-plus" color="rojo_claro" />
                </div>

            </div>
        
        </div>

        {{-- tabla --}}
        <div class="w-full not-dark:bg-white rounded-lg not-dark:shadow-md p-8 mt-3">
            <livewire:prestamo.index.table lazy />
        </div>

        
    </div>
</x-layouts::app>
