
<div>
    {{-- Simplicity is the consequence of refined emotions. - Jean D'Alembert --}}
    <flux:table :paginate="$this->equipos">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$this->sortBy === 'id'" :direction="$this->sortDirection" wire:click="sort('id')">ID</flux:table.column>
            <flux:table.column sortable :sorted="$this->sortBy === 'marca'" :direction="$this->sortDirection" wire:click="sort('marca')">Marca</flux:table.column>
            <flux:table.column sortable :sorted="$this->sortBy === 'modelo'" :direction="$this->sortDirection" wire:click="sort('modelo')">Modelo</flux:table.column>
            <flux:table.column>Unidades totales</flux:table.column>
            <flux:table.column>Estado</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>
        @forelse ($this->equipos as $equipo )
            <flux:table.row :key="$equipo->id">
                <flux:table.cell>{{ $equipo->id }}</flux:table.cell>
                <flux:table.cell>{{ $equipo->marca }}</flux:table.cell>
                <flux:table.cell>{{ $equipo->modelo}}</flux:table.cell>
                <flux:table.cell>{{ $this->cant_equipos($equipo->id) }}</flux:table.cell>
                <flux:table.cell>
                    @if ($this->cant_equipos($equipo->id) > 0)
                        <flux:badge size="sm" color="green" inset="top bottom">
                            Disponible
                        </flux:badge>
                    @else
                        <flux:badge size="sm" color="red" inset="top bottom">
                            No hay unidades disponibles
                        </flux:badge>
                    @endif
                </flux:table.cell>
                <flux:table.cell>
                    <button class="px-2 py-1 text-sm text-white bg-blue-500 rounded">Editar</button>
                    <button class="px-2 py-1 text-sm text-white bg-red-500 rounded">Eliminar</button>
                </flux:table.cell>
            </flux:table.row>
        @empty
            
        @endforelse
</div>