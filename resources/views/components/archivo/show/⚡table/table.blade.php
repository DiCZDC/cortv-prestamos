
<div>
    <div class="flex flex-col gap-5 ">
     {{-- The only way to do great work is to love what you do. - Steve Jobs --}}
    @placeholder
        <x-placeholder.table 
            :header="['Equipo', 'Sicipo', 'Mantenimiento']" />
    @endplaceholder
    
    <flux:table container:class="max-h-[295px]">
        <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
            <x-componentes.header_table icon="hard-drive"> Equipo </x-componentes.header_table> 
            <x-componentes.header_table icon="binary"> Sicipo </x-componentes.header_table>  
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($this->detalles() as $detalle)
                <flux:table.row>
                    
                    <flux:table.cell>
                        {{ $detalle->Unidad_Equipo->Equipo->marca }} {{ $detalle->Unidad_Equipo->Equipo->modelo }}
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="blue" class="text-azul_oscuro! ">{{ $detalle->Unidad_Equipo->sicipo }} </flux:badge>       
                    </flux:table.cell>
                </flux:table.row>
            @empty

                <flux:table.row>
                    <flux:table.cell colspan="3" class="text-center py-4">
                        No hay detalles disponibles.
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
    
        <div class="flex justify-center gap-30 ">               
            <flux:button 
                disabled
                icon="package-check" 
                class="bg-[#e7fac0]! text-[#3c6300]! font-bold text-sm! border-none!
                hover:bg-[#BFF056]! 
                hover:text-[#253D00]! 
                transition-all duration-200 ease-out 
                hover:-translate-y-1.5 active:scale-95 cursor-pointer">
                Recibir
            </flux:button>
        </div>
    </div>
           
    
        
 </div>

    
    