<div class="grid grid-cols-2 grid-rows-2 place-items-center content-center">
    
    <flux:modal.trigger name="modalDeudas">
    <livewire:card nombre_modal='modalDeudas' titulo='Mas deudas acumuladas' descripcion='Israel Juarez' icono='thumbs-down' color_bg='bg-rojo_claro' color_text='text-hueso'/>
    </flux:modal.trigger>
    
    <livewire:card titulo='Mantenimiento' descripcion='4 equipos reportados necesitan revision' icono='wrench' color_bg='bg-rojo_oscuro' color_text='text-hueso'/>
    <livewire:card titulo='Equipo más solicitado' descripcion='Conversor de audio' icono='award' color_text='text-black'/>    
    <livewire:card titulo='Equipo menos solicitado' descripcion='Conversor de video' icono='trending-down' color_bg='bg-black' color_text='text-hueso'/>

    <flux:modal name="modalDeudas" class="w-[500px] p-6 rounded-2xl">
    
        <div class="flex flex-col gap-4">
            <span class="font-semibold text-lg">Personal con mas deudas acumuladas</span>
            
            <flux:table>
    <flux:table.columns>
        <flux:table.column>Customer</flux:table.column>
        <flux:table.column>Date</flux:table.column>
        <flux:table.column>Status</flux:table.column>
        <flux:table.column>Amount</flux:table.column>
    </flux:table.columns>
    <flux:table.rows>
        <flux:table.row>
            <flux:table.cell>Lindsey Aminoff</flux:table.cell>
            <flux:table.cell>Jul 29, 10:45 AM</flux:table.cell>
            <flux:table.cell><flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge></flux:table.cell>
            <flux:table.cell variant="strong">$49.00</flux:table.cell>
        </flux:table.row>
        <flux:table.row>
            <flux:table.cell>Hanna Lubin</flux:table.cell>
            <flux:table.cell>Jul 28, 2:15 PM</flux:table.cell>
            <flux:table.cell><flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge></flux:table.cell>
            <flux:table.cell variant="strong">$312.00</flux:table.cell>
        </flux:table.row>
        <flux:table.row>
            <flux:table.cell>Kianna Bushevi</flux:table.cell>
            <flux:table.cell>Jul 30, 4:05 PM</flux:table.cell>
            <flux:table.cell><flux:badge color="zinc" size="sm" inset="top bottom">Refunded</flux:badge></flux:table.cell>
            <flux:table.cell variant="strong">$132.00</flux:table.cell>
        </flux:table.row>
        <flux:table.row>
            <flux:table.cell>Gustavo Geidt</flux:table.cell>
            <flux:table.cell>Jul 27, 9:30 AM</flux:table.cell>
            <flux:table.cell><flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge></flux:table.cell>
            <flux:table.cell variant="strong">$31.00</flux:table.cell>
        </flux:table.row>
    </flux:table.rows>
</flux:table>
                
        </div>

        <div class="mt-6 flex justify-end">
            <flux:button variant="primary" x-on:click="$flux.modal('modalDeudas').close()">
                Cerrar
            </flux:button>
        </div>
    </flux:modal>

</div>

