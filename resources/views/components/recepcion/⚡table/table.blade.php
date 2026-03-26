<div>    
    @livewire('searchbar', 
    [
        'filter' => ['all' => 'Todos', 'atrasado' => 'Atrasado', 'tiempo' => 'En tiempo'],
        'search_var'=> $search
    ])
        
    <flux:table :paginate="$this->prestamos" pagination:scroll-to   >
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'id'" :direction="$sortDirection" wire:click="sort('id')">ID</flux:table.column>
            <flux:table.column>Trabajador</flux:table.column>
            <flux:table.column>Administrador</flux:table.column>
            <flux:table.column>Motivo</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'fecha_prestamo'" :direction="$sortDirection" wire:click="sort('fecha_prestamo')">Fecha Préstamo</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'fecha_devolucion'" :direction="$sortDirection" wire:click="sort('fecha_devolucion')">Fecha Devolución</flux:table.column>
            <flux:table.column>Estado del Prestamo</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>

        
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($this->prestamos as $prestamo)
                <flux:table.row :key="$prestamo->id">

                    <flux:table.cell class="flex items-center gap-3">
                        {{ $prestamo->id }}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap">
                        {{ $prestamo->nombre_trabajador}}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap">
                        {{ $prestamo->nombre_admin}}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap">
                        {{ Str::limit($prestamo->motivo, 30, '...') }}
                    </flux:table.cell>

                    <flux:table.cell variant="strong">{{ $prestamo->fecha_prestamo }}</flux:table.cell>
                    <flux:table.cell variant="strong">{{ $prestamo->fecha_devolucion }}</flux:table.cell>

                    {{-- Fecha real de entrega --}}
                    <flux:table.cell variant="strong">
                        <flux:badge
                            size="sm"
                            :color="$prestamo->fecha_devolucion < now() ?  'red' : 'green'"
                            inset="top bottom"
                        >
                            {{
                                $prestamo->fecha_devolucion < now() ? "Prestamo atrasado" : "Prestamo en tiempo"
                            }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />
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