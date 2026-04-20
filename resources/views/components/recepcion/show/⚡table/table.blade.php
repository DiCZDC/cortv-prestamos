<div class="flex flex-col gap-6">
     {{-- The only way to do great work is to love what you do. - Steve Jobs --}}
    @placeholder
        <x-placeholder.table 
            :header="['Equipo', 'Sicipo', 'Estado']" />
    @endplaceholder
    
    <flux:table container:class="max-h-[225px]">
        <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
            <x-componentes.header_table icon="hard-drive"> Equipo </x-componentes.header_table> 
            <x-componentes.header_table icon="binary"> Sicipo </x-componentes.header_table> 
            
            <flux:table.column> 
            
            <div class="flex flex-col">
                <div>
                    <span class="inline-flex items-center gap-2 whitespace-nowrap text-gris_claro text-base font-semibold">
            
                        <flux:icon.unplug class="text-gris_claro!" />  Mantenimiento  
                    </span>
                </div>
                <div class="pl-8">
                    <span class="text-gris_claro text-xs font-light">¿El equipo requiere mantenimiento?</span>
                </div>      

            </div>
            
            
            </flux:table.column>  
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($this->detalles as $detalle)
                <flux:table.row>
                    
                    <flux:table.cell>
                        {{ $detalle->Unidad_Equipo->Equipo->marca }} {{ $detalle->Unidad_Equipo->Equipo->modelo }}
                    </flux:table.cell>
                    
                    <flux:table.cell>
                            {{ $detalle->Unidad_Equipo->sicipo }}
                    </flux:table.cell>
                    
                    <flux:table.cell >
                        
                        <div class="flex items-center gap-3 px-8! ">
                            <span>Si</span>
                            <flux:checkbox value="english" />
                        </div>    
                    
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
    
        <div class="flex justify-center gap-30 mt-5">               
            
            <flux:modal.trigger name="Confirmar">
                <x-btn-wire wire="" texto="Recibir" color="verde_mid" icon="luggage"/>
            </flux:modal.trigger>

        </div>
           
       
        

    
    <flux:modal name="Confirmar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Aprobar rececpción</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de aprobar esta recepción.<br>
                    Esta acción no se puede deshacer.
                </flux:text>
            </div>
            
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Regresar</flux:button>
                </flux:modal.close>
                
                <flux:modal.close>
                    <x-btn-wire wire="actualizar" texto="Recibir" color="verde_mid" icon="luggage" />
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="Rechazar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Rechazar solicitud</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de rechazar esta solicitud.<br>
                    Esta acción no se puede deshacer.
                </flux:text>
            </div>
            
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Regresar</flux:button>
                </flux:modal.close>
                
                <flux:modal.close>
                    <x-btn-wire wire="actualizar" texto="Rechazar" color="rojo_claro" icon="book-x" />
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>

</div>