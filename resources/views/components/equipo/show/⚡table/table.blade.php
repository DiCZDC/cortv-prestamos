@placeholder
    <x-placeholder.table
        :header="['ID', 'SICIPO', 'Estatus']"
        perPage=10
    />
@endplaceholder
<div class="w-full">
    <flux:table :paginate="$this->productos" pagination:scroll-to   >
        <flux:table.columns>
            <x-componentes.header_table icon="hashtag"> ID </x-componentes.header_table>
            <x-componentes.header_table icon="tag"> SICIPO </x-componentes.header_table>
            <x-componentes.header_table icon="info"> Estatus </x-componentes.header_table>
            <x-componentes.header_table icon="eye"> Acciones </x-componentes.header_table>
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
                            :color="!$producto->mantenimiento ? 'green' : (
                                $this->equipos_prestados()->contains($producto->id) ? 'red' :
                                'yellow')"
                            inset="top bottom"
                        >
                            {{ !$producto->mantenimiento ? 'Disponible' : 
                               ($this->equipos_prestados()->contains($producto->id) ? 'Prestado' :
                                'En Mantenimiento') 
                            }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        @if(!$this->equipos_prestados()->contains($producto->id))
                            <flux:button size="sm" variant="primary" class="bg-azul_saturado border-none!" color="sky" wire:click="toggleMantenimiento({{ $producto->id }})">
                                Cambiar Estado
                            </flux:button>
                        @else
                            <flux:button disabled size="sm" variant="primary" class="bg-azul_saturado border-none!" color="sky" wire:click="toggleMantenimiento({{ $producto->id }})">
                                Cambiar Estado
                            </flux:button>
                        @endif
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