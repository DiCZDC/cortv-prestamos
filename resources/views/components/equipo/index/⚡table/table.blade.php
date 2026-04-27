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
    
    <livewire:componentes.searchbar 
        placeholder="Buscar por marca o modelo..."
        :filters="$this->filters" />
    <flux:table :paginate="$this->equipos">
        <flux:table.columns>
            <x-componentes.header_table/>
            <x-componentes.header_table sortable="id" :sortBy="$sortBy" :sortDirection="$sortDirection"> ID </x-componentes.header_table>            
            <x-componentes.header_table sortable="marca" :sortBy="$sortBy" :sortDirection="$sortDirection" icon="tag">Marca</x-componentes.header_table>
            <x-componentes.header_table sortable="modelo" :sortBy="$sortBy" :sortDirection="$sortDirection" icon="cog">Modelo</x-componentes.header_table>
            <x-componentes.header_table icon="tool-case">Unidades totales</x-componentes.header_table>
            <x-componentes.header_table icon="target">Acciones</x-componentes.header_table>
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
                    {{-- <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button> --}}
                    <x-componentes.boton-href ruta="equipo.show" texto="Ver" icon="eye" :id="$equipo->id" color="azul_saturado" />    
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
        <flux:select.option value="6">6</flux:select.option>
        <flux:select.option value="12">12</flux:select.option>
        <flux:select.option value="24">24</flux:select.option>
        <flux:select.option value="48">48</flux:select.option>
    </flux:select>
</div>