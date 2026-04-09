<div>
    @php
        $categorias = \App\Models\Categoria::get();
        $this->filters = ['' => 'Todos'];
        foreach ($categorias as $categoria)
            $this->filters[$categoria->id] = $categoria->nombre_categoria;

    @endphp
    {{-- Simplicity is the consequence of refined emotions. - Jean D'Alembert --}}
    
    @placeholder
        <x-placeholder.table 
            :header="['','ID', 'Marca', 'Modelo', 'Unidades totales']"  
            filter=true
            perPage=10
        />
    @endplaceholder
    
    <livewire:searchbar 
        placeholder="Buscar por marca o modelo..."
        :filters="$this->filters" />
    <flux:table :paginate="$this->equipos">
        <flux:table.columns>
            <flux:table.column></flux:table.column>

            <flux:table.column sortable :sorted="$this->sortBy === 'id'" :direction="$this->sortDirection" wire:click="sort('id')">ID</flux:table.column>
            <flux:table.column sortable :sorted="$this->sortBy === 'marca'" :direction="$this->sortDirection" wire:click="sort('marca')">Marca</flux:table.column>
            <flux:table.column sortable :sorted="$this->sortBy === 'modelo'" :direction="$this->sortDirection" wire:click="sort('modelo')">Modelo</flux:table.column>
            <flux:table.column>Unidades totales</flux:table.column>
        </flux:table.columns>
        
        @forelse ($this->equipos as $equipo )
            <flux:table.row :key="$equipo->id">
                <flux:table.cell>
                    <flux:icon :name="
                    $equipo->icono_categoria ? $equipo->icono_categoria : 'laptop'
                    " 
                    class="w-5 h-5" />
                </flux:table.cell>
                <flux:table.cell>{{ $equipo->id }}</flux:table.cell>
                <flux:table.cell>{{ $equipo->marca }}</flux:table.cell>
                <flux:table.cell>{{ $equipo->modelo}}</flux:table.cell>
                <flux:table.cell>{{ $this->cant_equipos($equipo->id) }}</flux:table.cell>
                <flux:table.cell>
                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                </flux:table.cell>
            </flux:table.row>
        @empty
            <flux:table.row>
                <flux:table.cell colspan="5" class="text-center py-4">
                    No se encontraron equipos.
                </flux:table.cell>
            </flux:table.row>
        @endforelse
    </flux:table>
    <flux:select size="sm" class="w-full sm:w-auto" wire:model.live="perPage">
        <flux:select.option value="10">10</flux:select.option>
        <flux:select.option value="25">25</flux:select.option>
        <flux:select.option value="50">50</flux:select.option>
        <flux:select.option value="100">100</flux:select.option>
    </flux:select>
</div>