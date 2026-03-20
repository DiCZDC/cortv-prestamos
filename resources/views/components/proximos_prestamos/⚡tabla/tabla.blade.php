<div>
<flux:table>
        <flux:table.columns>
            
        <flux:table.column></flux:table.column>

            <x-componentes.header_table> Equipo </x-componentes.header_table>
            <x-componentes.header_table> Solicitante </x-componentes.header_table>
            <x-componentes.header_table> Fecha </x-componentes.header_table>    
            
        </flux:table.columns>
        @forelse ($this->prestamos as $prestamo)
            <flux:table.row>
                <flux:table.cell> <flux:icon name="video"> </flux:table.cell>
                <flux:table.cell>Eveniet Cole Group</flux:table.cell>
                <flux:table.cell>Casas Veronica Andrea</flux:table.cell>
                <flux:table.cell>  <x-componentes.badge-table :dias="$dias"> En {{ $dias }} dias </x-componentes.badge-table> 
                </flux:table.cell>
            </flux:table.row>
        @empty
            <flux:table.rows>
                <flux:table.row>
                    <flux:table.cell colspan="4" class="text-center">No hay prestamos proximos a vencer</flux:table.cell>
                </flux:table.row>
            </flux:table.rows>
        @endforelse
    </flux:table>
</div>