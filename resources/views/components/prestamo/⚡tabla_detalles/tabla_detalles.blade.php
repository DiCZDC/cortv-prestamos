
<div class="flex flex-col gap-4">
     {{-- The only way to do great work is to love what you do. - Steve Jobs --}}

    {{-- The only way to do great work is to love what you do. - Steve Jobs --}}
    @placeholder
        <x-placeholder.table 
            :header="['Fecha Préstamo', 'Sicipo', 'Disponibilidad']" />
    @endplaceholder
    
    @if ($this->verificar_unidades_equipo()->isNotEmpty())
     
        <flux:callout variant="warning" icon="exclamation-circle" heading="Please verify your account to unlock all features." />

    @else
    
    <flux:callout variant="success" icon="check-circle" heading="La solicitud no tiene conflictos con otros préstamos" text="Todos los equipos solicitados están disponibles.
    Puede autorizarse de manera inmediata la solicitud." />
         
    @endif


    <flux:table>
        <flux:table.columns>
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
                    <flux:table.cell>
                        {{-- {{ $detalle->Unidad_Equipo->Equipo->id}} --}}
                        {{ $this->solicitud($detalle->Unidad_Equipo->Equipo->id) ? 'Disponible' : 'Equipo no disponible' }}
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

    <div class="flex align-middle justify-evenly">
        <flux:button variant="outline" icon="check" color="rojo_claro" class="mt-4" wire:click="asignarEquipos">
            Aceptar prestamo
        </flux:button>
        <flux:button variant="outline" icon="x" color="gris_claro" class="mt-4 ml-2" wire:click="cancelarAsignacion">
            Rechazar prestamo
        </flux:button>
    </div>
</div>