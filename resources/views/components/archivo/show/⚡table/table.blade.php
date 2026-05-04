
<div>
    <div class="flex flex-col gap-5 ">
     {{-- The only way to do great work is to love what you do. - Steve Jobs --}}
        @placeholder
            <x-placeholder.table 
                :header="['Equipo', 'Sicipo', 'Mantenimiento']" />
        @endplaceholder
        
        <flux:table container:class="max-h-[295px]">
            <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
                <x-componentes.header_table icon="hard-drive" class="dark:text-hueso"> Equipo </x-componentes.header_table> 
                <x-componentes.header_table icon="binary" class="dark:text-hueso"> Sicipo </x-componentes.header_table>  
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
    
        <div class=" w-full">               
            <div class=" mt-5 w-full">
                <flux:button disabled 
                        variant="primary" 
                        icon="clipboard-check" 
                        class="w-full 
                        {{ 
                            $this->solicitud()->estado === 'Autorizada' ? 'bg-verde_mid ': (
                                $this->solicitud()->estado === 'Rechazada' ? 'bg-rojo_claro ': (
                                    $this->solicitud()->estado === 'Devuelta' ? 'bg-azul_intenso ': (
                                        $this->solicitud()->estado === 'Entregada' ? 'bg-azul_saturado': 'bg-amarillo_logo'
                                    )
                                )
                            )
                            
                         }}
                        
                        
                        
                        border-none text-white"
                    >
                        {{ $this->solicitud()->estado }}
                </flux:button>
            </div>
        </div>
    </div>
           
    
        
 </div>

    
    