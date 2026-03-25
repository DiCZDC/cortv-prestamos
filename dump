<x-layouts::app :title="__('Prestamos Pendientes')">
   <div class="flex flex-row mb-10 justify-between gap-1">
        <div class="w-3/4 flex flex-col self-center items-start">
            {{-- Cabecera principal --}}
            <div class="mb-4 flex items-center gap-2 text-rojo_claro">
                <flux:icon name="file" class="inline size-13" />
                <span class="ml-2 text-5xl font-bold">
                    {{ __('Prestamos') }}
                </span>
            </div>
            <div class="mb-2 pl-1 flex items-center text-gris_claro align-middle gap-4">
                <flux:icon name="database" class="inline size-9" />
                <span class="text-[30px] -tracking-tighter text-gris_claro font-inter" style="font-style: normal;">
                    {{ __('Solicitudes de prestamos pendientes de aprobar') }}
                </span>
            </div>
        </div>


        <div class="w-1/4 flex justify-center items-center">
            <livewire:card titulo='4 Prestamos' descripcion='Pendientes de entrega' icono='box' color_text='black'/>    
        </div>
    </div>
    @livewire('prestamos.table')
   
    <x-componentes.boton-href ruta="prestamos.create" texto="Crear nuevo prestamo" icon="square-plus" color="rojo_claro" />
    

</x-layouts::app>
