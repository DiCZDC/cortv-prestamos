
<div>
    {{-- The only way to do great work is to love what you do. - Steve Jobs --}}
    <flux:table>
        <flux:table.columns>
            <x-componentes.header_table icon="hard-drive"> Fecha Préstamo </x-componentes.header_table> 
            <x-componentes.header_table icon="chart-no-axes-column-increasing"> Disponibilidad </x-componentes.header_table>
            <x-componentes.header_table icon="target" > Acciones</x-componentes.header_table>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($this->detalles as $detalle)
                <flux:table.row>
                    <flux:table.cell>
                        {{ $detalle->Unidad_Equipo->Equipo->marca }} {{ $detalle->Unidad_Equipo->Equipo->modelo }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {{-- {{ $detalle->Unidad_Equipo->Equipo->id}} --}}
                        {{ $this->solicitud($detalle->Unidad_Equipo->Equipo->id) ? 'Disponible' : 'Equipo no disponible' }}
                    </flux:table.cell>
                    <flux:table.cell>
                        <x-componentes.boton-href ruta="prestamos.show" texto="Asignar" icon="external-link" :id="$solicitudId" color="azul_oscuro" />        
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

    {{-- <x-componentes.boton-href ruta="prestamos.show" texto="Aceptar prestamo" icon="external" :id="$solicitudId" color="azul_oscuro" />         --}}
    <div class="flex align-middle justify-evenly">
        <flux:button variant="outline" icon="check" color="rojo_claro" class="mt-4" wire:click="asignarEquipos">
            Aceptar prestamo
        </flux:button>
        <flux:button variant="outline" icon="x" color="gris_claro" class="mt-4 ml-2" wire:click="cancelarAsignacion">
            Rechazar prestamo
        </flux:button>
    </div>
</div>