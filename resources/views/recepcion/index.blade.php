<x-layouts::app :title="__('Recepción')">
    <div class="flex flex-row gap"> 
        <div class=" pt-2 w-1/2 gap-6">
            {{-- Cabecera principal --}}
            <div class="mb-4 flex items-center gap-6 text-rojo_claro">
                <flux:icon name="truck" class="inline h-15 w-15" />
                <span class="ml-2 text-5xl font-semibold">
                    {{ __('Recepción de Equipos') }}
                </span>
            </div>
            <div class="mb-2 flex items-center text-gris_claro align-middle gap-7">
                <flux:icon name="database" class="inline h-10 w-10" />
                <span class="text-[30px] -tracking-tighter text-gris_claro font-inter" style="font-style: normal;">
                    {{ __('Devoluciones de productos.') }}
                </span>
            </div>
        </div>
        <div class="w-2/5 flex justify-between items-center ">
            <livewire:card titulo='Equipo más solicitado' descripcion='Conversor de audio' icono='award' color_text='black'/>    
            <livewire:card titulo='Equipo más solicitado' descripcion='Conversor de audio' icono='award' color_text='black'/>    
        
        </div>
    </div>  
</x-layouts::app>