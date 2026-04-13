<form wire:submit="actualizar">
<div class="flex flex-col gap-6">
     {{-- The only way to do great work is to love what you do. - Steve Jobs --}}

    {{-- The only way to do great work is to love what you do. - Steve Jobs --}}
    @placeholder
        <x-placeholder.table 
            :header="['Fecha Préstamo', 'Sicipo', 'Disponibilidad']" />
    @endplaceholder
    
    @if ($this->valido)
     
        <flux:callout variant="warning" icon="exclamation-circle" heading="La solicitud tiene conflictos con otros prestamos" text="Resuelve los conflictos antes de autorizar la solicitud." />

    @else
    
    <flux:callout variant="success" icon="check-circle" heading="La solicitud no tiene conflictos con otros préstamos" text="Todos los equipos solicitados están disponibles.
    Puede autorizarse de manera inmediata la solicitud." />
         
    @endif

    <flux:table container:class="max-h-[225px]">
        <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
            <x-componentes.header_table icon="hard-drive"> Equipo </x-componentes.header_table> 
            <x-componentes.header_table icon="binary"> Sicipo </x-componentes.header_table> 
            <x-componentes.header_table icon="chart-no-axes-column-increasing"> Disponibilidad </x-componentes.header_table>
            
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
                    <flux:table.cell class="!px-15" >
                        @if($this->equipos_libres($detalle->Unidad_Equipo->Equipo->id)->pluck('id')->contains($detalle->Unidad_Equipo->id))
                            <flux:badge color="green" class="!text-sm">
                                Disponible
                            </flux:badge>
                        @else
                            {{$valido = false}}
                            <flux:badge color="red" class="!text-sm">
                                No disponible
                            </flux:badge>
                        @endif
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
    @if($this->SolicitudInfo()->estado === 'Pendiente')
        <div class="flex align-middle justify-evenly mt-5">
            <x-componentes.btnsformulario type="submit" texto="Aprobar" color="verde_mid" icon="clipboard-check" />
            <x-componentes.btnsformulario type="button" texto="Rechazar" color="rojo_claro" icon="circle-x" />  
        </div>
    @endif
</div>
</form>