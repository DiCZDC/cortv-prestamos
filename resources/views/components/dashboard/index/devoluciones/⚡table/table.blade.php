<div>
    @placeholder
        <x-placeholder.table :header="['','Equipo', 'Solicitante', 'Fecha']"/>
    @endplaceholder
    <flux:table :paginate="$this->atrasados">
        <flux:table.columns>
            <flux:table.column class="hidden md:block"></flux:table.column>
            <x-componentes.header_table> Equipo </x-componentes.header_table>
            <x-componentes.header_table> Solicitante </x-componentes.header_table>
            <x-componentes.header_table> Fecha </x-componentes.header_table>    
        </flux:table.columns>
        <flux:table.row>
            @forelse ($this->atrasados as $prestamo)
            
            @php
                $dias = round(
                    \Carbon\Carbon::parse($prestamo->solicitud->fecha_devolucion)
                        ->diffInDays(now())
                );
            @endphp

            <flux:table.row>
                <flux:table.cell class="hidden md:block">
                    <flux:icon name="video" />
                </flux:table.cell>
                <flux:table.cell class="text-balance!">{{ $prestamo->unidad_equipo->equipo->marca . ' ' . $prestamo->unidad_equipo->equipo->modelo }}</flux:table.cell>
                <flux:table.cell class="text-balance!">{{ $prestamo->nombre_trabajador }}</flux:table.cell>
                <flux:table.cell>  
                    <x-componentes.badgeTable 
                        :dias="$dias"
                        :colores="['urgente' => '!bg-naranja_logo', 'proximo' => '!bg-rojo_claro', 'normal' => '!bg-rojo_oscuro']"
                    >
                        {{ $dias }} dias
                    </x-componentes.badgeTable>
                </flux:table.cell>
            </flux:table.row>
        

            @empty
                <flux:table.rows>
                        <flux:table.cell colspan="4" class="text-center">No hay prestamos atrasados</flux:table.cell>
                    </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>