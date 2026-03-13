
<div>
    {{-- Simplicity is the consequence of refined emotions. - Jean D'Alembert --}}
    <flux:table :paginate="$this->equipos">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$this->sortBy === 'id'" :direction="$this->sortDirection" wire:click="sort('id')">ID</flux:table.column>
            <flux:table.column sortable :sorted="$this->sortBy === 'marca'" :direction="$this->sortDirection" wire:click="sort('marca')">Marca</flux:table.column>
            <flux:table.column sortable :sorted="$this->sortBy === 'modelo'" :direction="$this->sortDirection" wire:click="sort('modelo')">Modelo</flux:table.column>
            <flux:table.column>Unidades totales</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>
        @forelse ($this->equipos as $equipo )
            <flux:table.row :key="$equipo->id">
                <flux:table.cell>{{ $equipo->id }}</flux:table.cell>
                <flux:table.cell>{{ $equipo->marca }}</flux:table.cell>
                <flux:table.cell>{{ $equipo->modelo}}</flux:table.cell>
                <flux:table.cell>{{ $this->cant_equipos($equipo->id) }}</flux:table.cell>
                <flux:table.cell>
                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                </flux:table.cell>
            </flux:table.row>
        @empty
            
        @endforelse
</div>