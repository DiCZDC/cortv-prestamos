<div>
<flux:table>
        <flux:table.columns>
            
        <flux:table.column></flux:table.column>

            <x-componentes.header_table> Equipo </x-componentes.header_table>
            <x-componentes.header_table> Solicitante </x-componentes.header_table>
            <x-componentes.header_table> Fecha </x-componentes.header_table>    
            
        </flux:table.columns>

        <flux:table.rows>
            <flux:table.row>
                <flux:table.cell> <flux:icon name="video"> </flux:table.cell>
                <flux:table.cell>Eveniet Cole Group</flux:table.cell>
                <flux:table.cell>Casas Veronica Andrea</flux:table.cell>
                <flux:table.cell>  <x-componentes.badge-table :dias="$dias"> En {{ $dias }} dias </x-componentes.badge-table> 
                </flux:table.cell>
            </flux:table.row>

            <flux:table.row>
                <flux:table.cell> <flux:icon name="mic-vocal"> </flux:table.cell>
                <flux:table.cell>Jul 28, 2:15 PM</flux:table.cell>
                <flux:table.cell><flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge></flux:table.cell>
                <flux:table.cell variant="strong">$312.00</flux:table.cell>
            </flux:table.row>

            <flux:table.row>
                <flux:table.cell> <flux:icon name="cable"> </flux:table.cell>
                <flux:table.cell>Jul 30, 4:05 PM</flux:table.cell>
                <flux:table.cell><flux:badge color="zinc" size="sm" inset="top bottom">Refunded</flux:badge></flux:table.cell>
                <flux:table.cell variant="strong">$132.00</flux:table.cell>
            </flux:table.row>

            <flux:table.row>
                <flux:table.cell class="px-0!"> <flux:icon name="headset"> </flux:table.cell>
                <flux:table.cell>Jul 27, 9:30 AM</flux:table.cell>
                <flux:table.cell><flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge></flux:table.cell>
                <flux:table.cell variant="strong">$31.00</flux:table.cell>
            </flux:table.row>

            <flux:table.row>
                <flux:table.cell> <flux:icon name="laptop"> </flux:table.cell>
                <flux:table.cell>Jul 27, 9:30 AM</flux:table.cell>
                <flux:table.cell><flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge></flux:table.cell>
                <flux:table.cell variant="strong">$31.00</flux:table.cell>
            </flux:table.row>


        </flux:table.rows>
    </flux:table>
</div>