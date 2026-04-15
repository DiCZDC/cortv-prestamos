<div>    
    @placeholder
        <x-placeholder.table 
            :header="['ID', 'Trabajador', 'Administrador', 'Motivo', 'Fecha Préstamo', 'Fecha Devolución', 'Estado ', 'Acciones']" 
            filter=true 
            perPage=10 
            />
    @endplaceholder
    <livewire:componentes.searchbar 
        placeholder="Buscar por nombre de trabajador, administrador o motivo..."
        :filters="[
            'all' => 'Todos', 
            'atrasado' => 'Atrasado', 
            'tiempo' => 'En tiempo'
            ]"
    />
        
    <flux:table :paginate="$this->prestamos" pagination:scroll-to   >
        <flux:table.columns>
            <x-componentes.header_table sortable="id" :sortBy="$sortBy" :sortDirection="$sortDirection"> ID </x-componentes.header_table>
            <x-componentes.header_table icon="book-user"> Solicitante </x-componentes.header_table>
            <x-componentes.header_table icon="shield-user"> Aprobado por </x-componentes.header_table>
            <x-componentes.header_table icon="scroll-text"> Motivo </x-componentes.header_table>
            <x-componentes.header_table icon="calendar-1" sortable="fecha_prestamo" :sortBy="$sortBy" :sortDirection="$sortDirection"> Fecha Préstamo </x-componentes.header_table>
            <x-componentes.header_table icon="calendar-off" sortable="fecha_devolucion" :sortBy="$sortBy" :sortDirection="$sortDirection"> Fecha Devolución </x-componentes.header_table>
            <x-componentes.header_table icon="info"> Estado </x-componentes.header_table>
            <x-componentes.header_table icon="target"> Acciones </x-componentes.header_table>
        
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

                    <flux:table.cell variant="strong">  <flux:badge> {{ $prestamo->fecha_prestamo }} </flux:badge></flux:table.cell>
                    <flux:table.cell variant="strong"> <flux:badge> {{ $prestamo->fecha_devolucion }} </flux:badge></flux:table.cell>

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
                        <x-componentes.boton-href ruta="recepcion.show" texto="Ver" icon="eye" :id="$prestamo->id" color="azul_saturado" />    
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