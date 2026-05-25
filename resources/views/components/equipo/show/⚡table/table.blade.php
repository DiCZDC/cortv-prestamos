@placeholder
    <x-placeholder.table
        :header="['ID', 'SICIPO', 'Estatus']"
        perPage=10
    />
@endplaceholder
<div class="w-full">
    <flux:table :paginate="$this->productos" pagination:scroll-to   >
        <flux:table.columns>
            <x-componentes.header_table align="center" icon="hashtag"> ID </x-componentes.header_table>
            <x-componentes.header_table align="center" icon="tag"> SICIPO </x-componentes.header_table>
            <x-componentes.header_table align="center" icon="info"> Estatus </x-componentes.header_table>
            <x-componentes.header_table align="center" icon="eye"> Acciones </x-componentes.header_table>
        </flux:table.columns>

        <flux:table.rows >
            @forelse ($this->productos as $producto)
                <flux:table.row :key="$producto->id">
                    <flux:table.cell  class="flex items-center gap-3">
                        {{ $producto->id }}
                    </flux:table.cell>
                    <flux:table.cell align="center" class="whitespace-nowrap">
                        {{ $producto->sicipo }}
                    </flux:table.cell>
                    <flux:table.cell align="center" class="whitespace-nowrap">
                        <flux:badge
                            :color=" 
                                $this->equipos_prestados()->where('id_unidad_equipo', $producto->id)->exists() ? 'red' :(
                                !$producto->mantenimiento ? 'green' : 'yellow'
                                )"
                            inset="top bottom"
                        >
                            {{ 
                               $this->equipos_prestados()->where('id_unidad_equipo', $producto->id)->exists() ? 'Prestado' :(
                                !$producto->mantenimiento ? 'Disponible' :  'En Mantenimiento')
                            }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap flex items-center gap-4 justify-center ">

                        @php 
                            $prestamos_act = $this->equipos_prestados()->where('id_unidad_equipo', $producto->id);
                            $prestado = $prestamos_act->exists();
                        @endphp
                        @if(!$prestado)
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
                        @else
                            <flux:button
                                title="Solicitado por: {{ $prestamos_act->first()->solicitud->trabajador->name }}"
                                icon="eye"
                                size="sm"
                                variant="primary"
                                class="bg-azul-hover! text-azul_oscuro! font-bold text-sm! border-none!
                                    hover:bg-azul_oscuro! 
                                    hover:text-hueso!
                                    transition all delay-100 duration-200 ease-out 
                                    hover:-translate-y-1.5 active:scale-92 cursor-pointer"
                                href="{{ route('archivo.show', $prestamos_act->first()?->id_solicitud) }}" 
                                >
                                Ver Prestamo
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