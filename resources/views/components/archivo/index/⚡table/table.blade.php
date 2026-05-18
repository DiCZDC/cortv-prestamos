<div class="mt-4">
    @placeholder
        <x-placeholder.table 
            :header="['ID', 'Trabajador', 'Motivo', 'Estado del Prestamo', 'Fecha Préstamo', 'Fecha Devolución', 'Fecha Real de Entrega', 'Acciones']" 
            filter=true />
    @endplaceholder
    <livewire:componentes.searchbar 
        :filters="[
            '' => 'Todos',
            'Autorizada' => 'Autorizada',
            'Pendiente' => 'Pendiente',
            'Entregada' => 'Entregada',
            'Devuelta' => 'Devuelta',
            'Rechazada' => 'Rechazada',
        ]"/>
    <flux:table :paginate="$this->prestamos">
        <flux:table.columns>
            <x-componentes.header_table sortable="id" :sortBy="$sortBy" :sortDirection="$sortDirection"> ID </x-componentes.header_table>            
            @role('admin')
                <x-componentes.header_table icon="contact-round"> Trabajador</x-componentes.header_table>            
            @endrole
            {{-- <x-componentes.header_table icon="shield-user"> Aprobado por</x-componentes.header_table> --}}
            <x-componentes.header_table icon="scroll-text"> Motivo</x-componentes.header_table>
            @role('admin')
                <x-componentes.header_table sortable="id" :sortBy="$sortBy" :sortDirection="$sortDirection" icon="calendar"> Fecha de Solicitud</x-componentes.header_table>
            @endrole
            <x-componentes.header_table icon="book-heart"> Estado del Préstamo</x-componentes.header_table>
            <x-componentes.header_table sortable="fecha_prestamo" :sortBy="$sortBy" :sortDirection="$sortDirection" icon="calendar-arrow-down"> Fecha Préstamo</x-componentes.header_table>
            <x-componentes.header_table sortable="fecha_devolucion" :sortBy="$sortBy" :sortDirection="$sortDirection" icon="calendar-arrow-up"> Fecha Devolución</x-componentes.header_table>
            <x-componentes.header_table sortable="fecha_entrega" :sortBy="$sortBy" :sortDirection="$sortDirection" icon="calendar-check-2"> Fecha Real de Entrega</x-componentes.header_table>
            <x-componentes.header_table > Acciones </x-componentes.header_table>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($this->prestamos as $prestamo)
                <flux:table.row :key="$prestamo->id">

                    <flux:table.cell class="flex items-center gap-3">
                        {{ $prestamo->id }}
                    </flux:table.cell>
                    @role('admin')
                        <flux:table.cell class="whitespace-nowrap">
                            {{ $prestamo->nombre_trabajador}}
                        </flux:table.cell>
                    @endrole
                    {{-- <flux:table.cell class="whitespace-nowrap">
                        {{ $prestamo->nombre_admin}}
                    </flux:table.cell> --}}

                    <flux:table.cell class="whitespace-nowrap">
                        {{ Str::limit($prestamo->motivo, 30, '...') }}
                    </flux:table.cell>
                    @role('admin')
                    <flux:table.cell variant="strong">{{ $prestamo->created_at->format('Y-m-d') }}</flux:table.cell>
                    @endrole
                    {{-- Estado del préstamo --}}
                    <flux:table.cell>
                        <flux:badge
                            size="sm"
                            :color="$prestamo->estado === 'Autorizada' ? 'green' 
                            : ($prestamo->estado === 'Entregada' ? 'cyan' 
                            : ($prestamo->estado === 'Pendiente' ? 'yellow' 
                            :($prestamo->estado === 'Rechazada' ? 'red' : 'blue')))"
                            inset="top bottom"
                        >
                            {{ $prestamo->estado }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell variant="strong">{{ $prestamo->fecha_prestamo }}</flux:table.cell>

                    <flux:table.cell variant="strong">{{ $prestamo->fecha_devolucion }}</flux:table.cell>

                    {{-- Fecha real de entrega --}}
                    <flux:table.cell variant="strong">
                        @if ($prestamo->fecha_entrega!== null)
                        <flux:badge
                            size="sm"
                            :color="$prestamo->fecha_entrega <= $prestamo->fecha_devolucion ? 'green' : 'red'"
                            inset="top bottom">
                            {{ 

                                $prestamo->fecha_entrega
                            
                            }}
                        </flux:badge>
                        @elseif ($prestamo->estado === 'Entregada')
                            <span class="text-sm text-gris_claro">En espera</span>
                        @else
                            <span class="text-sm text-gris_claro">No entregado</span>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <x-componentes.boton-href ruta="archivo.show" texto="Ver" icon="eye" :id="$prestamo->id" />    
                    </flux:table.cell>

                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="9" class="text-center py-4">
                        No se encontraron préstamos.
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
    <flux:select size="sm" class="w-full sm:w-auto" wire:model.live="perPage">
        <flux:select.option value="8">8</flux:select.option>
        <flux:select.option value="16">16</flux:select.option>
        <flux:select.option value="32">32</flux:select.option>
        <flux:select.option value="64">64</flux:select.option>
    </flux:select>
</div>