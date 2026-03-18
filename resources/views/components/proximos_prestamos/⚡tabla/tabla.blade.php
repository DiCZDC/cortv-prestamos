<div>
<flux:table>
        <flux:table.columns>
            
        <flux:table.column></flux:table.column>
            <flux:table.column  class=" text-gris_claro! text-base! font-semibold" >Equipo</flux:table.column>
            <flux:table.column class=" text-gris_claro! text-base! font-semibold" >Solicitante</flux:table.column>
            <flux:table.column class=" text-gris_claro! text-base! font-semibold" >Tiempo</flux:table.column>

        </flux:table.columns>

        <flux:table.rows>
            <flux:table.row>
                <flux:table.cell> <flux:icon name="video"> </flux:table.cell>
                <flux:table.cell>Jul 29, 10:45 AM</flux:table.cell>
                <flux:table.cell>
                 
                <flux:badge
                 @class([
                        '!bg-azul_saturado' => $dias <= 3,
                        '!bg-azul_intenso' => $dias > 3 && $dias <= 8,
                        '!bg-azul_oscuro' => $dias > 8,
                        '!text-hueso' => true
                    ])

                size="lg" inset="top bottom">Paid</flux:badge>
            
            </flux:table.cell>
                <flux:table.cell variant="strong">$49.00</flux:table.cell>
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