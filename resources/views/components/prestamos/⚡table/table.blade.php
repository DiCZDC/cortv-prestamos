<div>    
    <flux:table :paginate="$this->prestamos">
    <flux:table.columns>
        <flux:table.column sortable :sorted="$sortBy === 'id'" :direction="$sortDirection" wire:click="sort('id')">ID</flux:table.column>
        <flux:table.column>Trabajador</flux:table.column>
        <flux:table.column>Aprobado por</flux:table.column>
        <flux:table.column>Motivo</flux:table.column>
        <flux:table.column>Estado</flux:table.column>

        <flux:table.column sortable :sorted="$sortBy === 'fecha_prestamo'" :direction="$sortDirection" wire:click="sort('fecha_prestamo')">Fecha Prestamo</flux:table.column>
        <flux:table.column sortable :sorted="$sortBy === 'fecha_devolucion'" :direction="$sortDirection" wire:click="sort('fecha_devolucion')">Fecha Devolución</flux:table.column>
        <flux:table.column sortable :sorted="$sortBy === 'fecha_entrega'" :direction="$sortDirection" wire:click="sort('fecha_entrega')">Fecha Real de Entrega</flux:table.column>
        <flux:table.column>Acciones</flux:table.column>

    
    </flux:table.columns>

    <flux:table.rows>
        
        @foreach ($this->prestamos as $prestamo)
            <flux:table.row :key="$prestamo->id">
                {{-- ID del prestamo --}}
                <flux:table.cell class="flex items-center gap-3">
                    {{ $prestamo->id }}
                </flux:table.cell>
                {{-- Nombre del trabajador --}}
                <flux:table.cell class="whitespace-nowrap">
                    Nombre Trabajador
                </flux:table.cell>
                {{-- Nombre del admin que ha aprovado el prestamo  --}}
                <flux:table.cell class="whitespace-nowrap">
                    Nombre Admin
                </flux:table.cell>
                {{-- Motivo del prestamo --}}
                <flux:table.cell class="whitespace-nowrap">
                    {{ Str::limit($prestamo->motivo, 30, '...') }}
                </flux:table.cell>
                {{-- Estado del prestamo --}}
                <flux:table.cell>
                    @if($prestamo->fecha_entrega === null)
                        <flux:badge size="sm" color="blue" inset="top bottom">
                            Prestado
                        </flux:badge>
                    @elseif ($prestamo->fecha_prestamo > now())
                        <flux:badge size="sm" color="amber" inset="top bottom">
                            Pendiente
                        </flux:badge>
                    @else
                        <flux:badge size="sm" color="green" inset="top bottom">
                            Devuelto
                        </flux:badge>
                    @endif
                </flux:table.cell>
                {{-- Fecha de prestamo --}}
                <flux:table.cell variant="strong">
                    {{ $prestamo -> fecha_prestamo }}
                </flux:table.cell>
                <flux:table.cell variant="strong">
                    {{ $prestamo -> fecha_devolucion }}
                </flux:table.cell>
                <flux:table.cell variant="strong">
                    {{ $prestamo -> fecha_entrega ?? 'Aun no devuelto' }}
                </flux:table.cell>
                <flux:table.cell>
                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                </flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>


</div>