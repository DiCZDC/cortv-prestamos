
<div>
    {{-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi --}}
    <flux:table :paginate="$this->prestamos">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'id'" :direction="$sortDirection" wire:click="sort('id')">ID</flux:table.column>
            <flux:table.column>Aprobado por</flux:table.column>
            <flux:table.column>Motivo</flux:table.column>
            <flux:table.column>Estado</flux:table.column>
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
                    
                    <flux:table.cell class="whitespace-nowrap">
                        {{ $prestamo->name ?? 'Pendiente de Aprobación' }}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap">
                        {{ Str::limit($prestamo->motivo, 30, '...') }}
                    </flux:table.cell>

                    {{-- Estado del préstamo --}}
                    <flux:table.cell>
                        <flux:badge
                            size="sm"
                            :color="$prestamo->fecha_entrega === null ? 'blue' : ($prestamo->fecha_prestamo > now() ? 'amber' : 'green')"
                            inset="top bottom"
                        >
                            {{ $prestamo->fecha_entrega === null ? 'Prestado' : ($prestamo->fecha_prestamo > now() ? 'Pendiente' : 'Devuelto') }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell variant="strong">{{ $prestamo->fecha_prestamo }}</flux:table.cell>
                    <flux:table.cell variant="strong">{{ $prestamo->fecha_devolucion }}</flux:table.cell>

                    {{-- Fecha real de entrega --}}
                    <flux:table.cell variant="strong">
                        <flux:badge
                            size="sm"
                            :color="$prestamo->fecha_entrega
                                ? ($prestamo->fecha_entrega <= $prestamo->fecha_devolucion ? 'green' : 'red')
                                : 'gray'"
                            inset="top bottom"
                        >
                            {{ $prestamo->fecha_entrega ?? 'Aún no devuelto' }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />
                    </flux:table.cell>

                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="9" class="text-center py-4">
                        No has realizado ninguna solicitud de prestamo.
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
    
</div>