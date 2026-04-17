<div>
    @placeholder
        <x-placeholder.table 
            :header="['ID', 'Trabajador', 'Motivo', 'Fecha Préstamo', 'Fecha Devolución', 'Acciones']" 
            searchbar=true 
            perPage=6
        />
    @endplaceholder
    <livewire:componentes.searchbar
        placeholder="Buscar por nombre de trabajador o motivo..."
    />
    <flux:table :paginate="$this->prestamos" pagination:scroll-to   >
        <flux:table.columns>
            <x-componentes.header_table sortable="id" :sortBy="$sortBy" :sortDirection="$sortDirection"> ID </x-componentes.header_table>
            <x-componentes.header_table icon="contact-round"> Trabajador </x-componentes.header_table>
            <x-componentes.header_table icon="library-big"> Motivo </x-componentes.header_table>
            <x-componentes.header_table icon="calendar-1" sortable="fecha_prestamo" :sortBy="$sortBy" :sortDirection="$sortDirection"> Fecha Préstamo </x-componentes.header_table>
            <x-componentes.header_table icon="calendar-off" sortable="fecha_devolucion" :sortBy="$sortBy" :sortDirection="$sortDirection"> Fecha Devolución </x-componentes.header_table>
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
                            <x-componentes.boton-href ruta="entrega.show" texto="Ver" icon="eye" :id="$prestamo->id" color="azul_saturado" />    
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
        <flux:select.option value="8">8</flux:select.option>
        <flux:select.option value="12">12</flux:select.option>
        <flux:select.option value="24">24</flux:select.option>
        <flux:select.option value="48">48</flux:select.option>
    </flux:select>
</div>