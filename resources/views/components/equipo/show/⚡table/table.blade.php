<div>
    <flux:table :paginate="$this->productos" pagination:scroll-to   >
        <flux:table.columns>
            <x-componentes.header_table icon="hashtag"> ID </x-componentes.header_table>
            <x-componentes.header_table icon="tag"> SICIPO </x-componentes.header_table>
            <x-componentes.header_table icon="info"> Estatus </x-componentes.header_table>
        </flux:table.columns>

        <flux:table.rows >
            @forelse ($this->productos as $producto)
                <flux:table.row :key="$producto->id">
                    <flux:table.cell class="flex items-center gap-3">
                        {{ $producto->id }}
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        {{ $producto->sicipo }}
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        <flux:badge
                            size="sm"
                            :color="$producto->estado === 'Prestado' ? 'orange' 
                            : ($producto->estado === 'Reservado' ? 'blue' 
                            : ($producto->estado === 'Pendiente' ? 'yellow' 
                            :($producto->estado === 'En reparación' ? 'red' : 'cyan')))"
                            inset="top bottom"
                        >
                            {{ $producto->estado }}
                        </flux:badge>    
                    {{-- <flux:badge color="{{ $producto->estado === 'Disponible' ? 'verde_claro' : 'rojo_claro' }}">
                            {{ $producto->estado }}
                        </flux:badge> --}}
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
</div>