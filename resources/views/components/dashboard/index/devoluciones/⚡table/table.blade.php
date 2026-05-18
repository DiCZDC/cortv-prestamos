<div class="bg-hueso rounded-xl dark:bg-zinc-900">
    <div class="flex flex-row justify-start items-center gap-3 px-8 pt-8">
        <flux:icon name="clock-alert" class="w-9! h-9! text-black dark:text-hueso" />
        <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem] dark:text-hueso"> Prestamos Atrasados</span>
    </div>
                        
    <div class="pt-3 px-10 pb-6" >
    
        @placeholder
            <x-placeholder.table :header="['','Equipo', 'Solicitante', 'Días Atrasados']"/>
        @endplaceholder
        <flux:table :paginate="$this->atrasados">
            <flux:table.columns>
                <flux:table.column class="hidden md:block"></flux:table.column>
                <x-componentes.header_table> Motivo </x-componentes.header_table>
                @role('admin')
                     <x-componentes.header_table> Solicitante </x-componentes.header_table>
                @endrole
                <x-componentes.header_table> Días Atrasados </x-componentes.header_table>    
            </flux:table.columns>
            <flux:table.row>
                @forelse ($this->atrasados as $prestamo)
                
                @php
                    $dias = floor(
                        \Carbon\Carbon::parse($prestamo->fecha_devolucion)
                            ->diffInDays(now())
                    );
                @endphp
    
                <flux:table.row>
                    <flux:table.cell class="hidden md:block">
                        <flux:icon name="video" />
                    </flux:table.cell>
                    <flux:table.cell class="text-balance!">{{ $prestamo->motivo}}</flux:table.cell>
                    
                    @role('admin')
                        <flux:table.cell class="text-balance!">{{ $prestamo->trabajador->name }}</flux:table.cell>
                    @endrole
                    <flux:table.cell>  
                        {{-- <x-componentes.badgeTable 
                        :dias="$dias"
                        :colores="['urgente' => '!bg-naranja_logo', 'proximo' => '!bg-rojo_claro', 'normal' => '!bg-rojo_oscuro']"
                        >
                        {{ $dias }} dias
                    </x-componentes.badgeTable> --}}
                    <x-componentes.boton-href ruta="recepcion.show" texto="{{ $dias }} dias" icon="eye" :id="$prestamo->id" />    
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
<div>
</div>