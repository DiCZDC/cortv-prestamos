<div>
    @placeholder
        <x-placeholder.table :header="['','Equipo', 'Solicitante', 'Fecha']" />
    @endplaceholder
    <flux:table :paginate="$this->prestamos" >
        <flux:table.columns>
            <flux:table.column class="hidden md:block"></flux:table.column>
            <x-componentes.header_table> Equipo </x-componentes.header_table>
            @role('admin')
                <x-componentes.header_table> Solicitante </x-componentes.header_table>
            @endrole
            <x-componentes.header_table> Fecha </x-componentes.header_table>    
            
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($this->prestamos as $prestamo)
                @php
                    $dias = round(now()->diffInDays($prestamo->solicitud->fecha_prestamo));
                @endphp
                <flux:table.row>
                    <flux:table.cell class="hidden md:block">
                        <flux:icon name="video" />
                    </flux:table.cell>
                    <flux:table.cell class="text-balance!">{{ $prestamo->unidad_equipo->equipo->marca . ' ' . $prestamo->unidad_equipo->equipo->modelo }}</flux:table.cell>
                    @role('admin')
                        <flux:table.cell class="text-balance!">{{ $prestamo->nombre_trabajador }}</flux:table.cell>
                    @endrole
                    <flux:table.cell>  
                        <x-componentes.badgeTable :dias="$dias" > 
                            @php
                                $texto =match(true){
                                        $dias == 0 => 'Hoy',
                                        $dias == 1 => 'Mañana',
                                        $dias > 1 => "En $dias dias",
                                    }
                            @endphp
                            {{$texto}}
                        </x-componentes.badgeTable> 
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    @if(auth()->user()->hasRole('trabajador'))
                        <flux:table.cell colspan="4" class="text-center">No tienes prestamos proximos a recibir</flux:table.cell>
                    @else
                         <flux:table.cell colspan="4" class="text-center">No hay prestamos proximos a vencer</flux:table.cell>
                    @endif
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>