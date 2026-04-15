<div class="mt-4">
    @placeholder
        <x-placeholder.table 
            :header="['ID', 'Trabajador', 'Administrador', 'Motivo', 'Estado del Prestamo', 'Fecha Préstamo', 'Fecha Devolución', 'Fecha Real de Entrega', 'Acciones']" 
            filter=true />
    @endplaceholder
    <livewire:componentes.searchbar 
        :filters="[
            '' => 'Todos',
            'Autorizada' => 'Autorizada',
            // 'Pendiente' => 'Pendiente',
            'Entregada' => 'Entregada',
            'Devuelta' => 'Devuelta',
            'Rechazada' => 'Rechazada',
        ]"/>

    <flux:table :paginate="$this->prestamos">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'id'" :direction="$sortDirection" wire:click="sort('id')">ID</flux:table.column>
            @role('admin')
                <flux:table.column>Trabajador</flux:table.column>
            @endrole
            <flux:table.column>Aprobado por</flux:table.column>
            <flux:table.column>Motivo</flux:table.column>
            @role('admin')
                <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">Fecha de Solicitud</flux:table.column>
            @endrole
            <flux:table.column>Estado del Préstamo</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'fecha_prestamo'" :direction="$sortDirection" wire:click="sort('fecha_prestamo')">Fecha Préstamo</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'fecha_devolucion'" :direction="$sortDirection" wire:click="sort('fecha_devolucion')">Fecha Devolución</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'fecha_entrega'" :direction="$sortDirection" wire:click="sort('fecha_entrega')">Fecha Real de Entrega</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
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
                    <flux:table.cell class="whitespace-nowrap">
                        {{ $prestamo->nombre_admin}}
                    </flux:table.cell>

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
                        <x-componentes.boton-href ruta="archivo.show" texto="Ver" icon="eye" :id="$prestamo->id" color="azul_saturado" />    
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
        <flux:select.option value="10">10</flux:select.option>
        <flux:select.option value="25">25</flux:select.option>
        <flux:select.option value="50">50</flux:select.option>
        <flux:select.option value="100">100</flux:select.option>
    </flux:select>
</div>