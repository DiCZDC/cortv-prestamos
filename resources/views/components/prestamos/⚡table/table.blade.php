<div>
    <flux:table :paginate="$this->prestamos">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'id'" :direction="$sortDirection" wire:click="sort('id')">ID</flux:table.column>
            <flux:table.column>Trabajador</flux:table.column>
            <flux:table.column>Motivo</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'fecha_prestamo'" :direction="$sortDirection" wire:click="sort('fecha_prestamo')">Fecha Préstamo</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'fecha_devolucion'" :direction="$sortDirection" wire:click="sort('fecha_devolucion')">Fecha Devolución</flux:table.column>
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
                        {{ Str::limit($prestamo->motivo, 30, '...') }}
                    </flux:table.cell>

                    
                    <flux:table.cell variant="strong">
                        <flux:badge>
                            {{ $prestamo->fecha_prestamo }}
                        </flux:badge>
                    </flux:table.cell>
                    
                    <flux:table.cell variant="strong">
                        <flux:badge>
                            {{ $prestamo->fecha_devolucion }}
                        </flux:badge>
                    </flux:table.cell>


                    <flux:table.cell>
                            <x-componentes.boton-href ruta="prestamos.show" texto="Ver" icon="eye" :id="$prestamo->id" color="azul_saturado" />    
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
        <flux:select.option value="6">6</flux:select.option>
        <flux:select.option value="12">12</flux:select.option>
        <flux:select.option value="24">24</flux:select.option>
        <flux:select.option value="48">48</flux:select.option>
    </flux:select>
</div>