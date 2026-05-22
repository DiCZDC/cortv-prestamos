<div>
    @php
        $categorias = \App\Models\Categoria::get();
        $badgePalette = [
            'zinc',
            'green',
            'emerald',
            'teal',
            'cyan',
            'sky',
            'blue',
            'indigo',
            'violet',
            'purple',
        ];
        $badgeColors = [];
        $this->filters = ['' => 'Todos'];
        foreach ($categorias as $index => $categoria) {
            $this->filters[$categoria->id] = $categoria->nombre_categoria;
            $badgeColors[$categoria->id] = $badgePalette[$index % count($badgePalette)];
        }

    @endphp
    {{-- Simplicity is the consequence of refined emotions. - Jean D'Alembert --}}
    
    @placeholder
        <x-placeholder.table 
            :header="['Categoria', 'Marca', 'Modelo', 'Unidades totales', 'Acciones']"  
            filter=true
            perPage=10
        />
    @endplaceholder
    
    <livewire:componentes.searchbar 
        placeholder="Buscar por marca o modelo..."
        :filters="$this->filters" />
    
        <flux:table :paginate="$this->equipos" class="
            lg:px-16 
            mt-3">
        <flux:table.columns>
            <x-componentes.header_table icon="layers" sortable="id_categoria" :sortBy="$sortBy" :sortDirection="$sortDirection">Categoria</x-componentes.header_table>
            <x-componentes.header_table sortable="marca" :sortBy="$sortBy" :sortDirection="$sortDirection" icon="tags">Marca</x-componentes.header_table>
            <x-componentes.header_table sortable="modelo" :sortBy="$sortBy" :sortDirection="$sortDirection" icon="cog">Modelo</x-componentes.header_table>
            <x-componentes.header_table align="center" icon="sigma">Unidades totales</x-componentes.header_table>
            <x-componentes.header_table icon="target">Acciones</x-componentes.header_table>
        </flux:table.columns>
        
        @forelse ($this->equipos as $equipo )
            <flux:table.row :key="$equipo->id">

                <flux:table.cell>
                    <flux:badge
                        :color="$badgeColors[$equipo->id_categoria] ?? 'zinc'"
                        :icon="$equipo->icono_categoria ? $equipo->icono_categoria : 'laptop'"
                    >
                        {{ $equipo->nombre_categoria }}
                    </flux:badge>
                </flux:table.cell>
                
                <flux:table.cell class="font-medium text-zinc-500!">{{ $equipo->marca }}</flux:table.cell>
                
                <flux:table.cell class="font-medium">{{ $equipo->modelo}}</flux:table.cell>
                
                <flux:table.cell align="center">
                    @php
                        $count = $this->cant_equipos($equipo->id);
                        $color = $count < 3 ? 'red' : ($count < 6 ? 'orange' : ($count < 10 ? 'lime' : 'green'));
                    @endphp

                    <flux:badge :color="$color">
                        {{ $count }} equipos
                    </flux:badge>
                </flux:table.cell>

                <flux:table.cell>
                    <x-componentes.boton-href ruta="equipo.show" texto="Ver" icon="eye" :id="$equipo->id" />    
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