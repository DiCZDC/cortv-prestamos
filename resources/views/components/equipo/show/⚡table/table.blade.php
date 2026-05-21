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
                    <flux:table.cell align="center" class="flex items-center gap-3">
                        {{ $producto->id }}
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        {{ $producto->sicipo }}
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        <flux:badge
                            :color=" 
                                $this->equipos_prestados()->contains($producto->id) ? 'red' :(
                                !$producto->mantenimiento ? 'green' : 'yellow'
                                )"
                            inset="top bottom"
                        >
                            {{ 
                               $this->equipos_prestados()->contains($producto->id) ? 'Prestado' :(
                                !$producto->mantenimiento ? 'Disponible' :  'En Mantenimiento')
                            }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap">

                        @php $prestado = $this->equipos_prestados()->contains($producto->id); @endphp

                        <flux:button
                            icon="arrow-left-right"
                            size="sm"
                            variant="primary"
                            :disabled="$prestado"
                            class="bg-azul-hover! text-azul_oscuro! font-bold text-sm! border-none!
                                hover:bg-azul_oscuro! 
                                hover:text-hueso!
                                transition all delay-100 duration-200 ease-out  
                                hover:-translate-y-1.5 active:scale-92 cursor-pointer"
                            wire:click="toggleMantenimiento({{ $producto->id }})">
                            Cambiar Estado
                        </flux:button>
                    
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