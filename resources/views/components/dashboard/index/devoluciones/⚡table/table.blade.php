<div class="bg-hueso rounded-xl dark:bg-zinc-900">
    <div class="flex flex-row justify-start items-center gap-3 px-10 pt-7">
        <flux:icon name="clock-alert" class="w-9! h-9! text-black dark:text-hueso" />
        <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem] dark:text-hueso"> Prestamos Atrasados</span>
    </div>
                        
    <div class="pt-3 px-14 pb-6" >
    
        @placeholder
            <x-placeholder.table :header="['Motivo', 'Solicitante', 'Días Atrasados']"/>
        @endplaceholder
        <flux:table :paginate="$this->atrasados">
            <flux:table.columns>
                
                <flux:table.column class="w-[250px]!" >
                        <span class="inline-flex items-center gap-2 whitespace-nowrap text-gris_claro text-base font-semibold">
                                <flux:icon.scroll-text  class="text-gris_claro!" />
                                Motivo
                        </span> 
                </flux:table.column>

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
                    <flux:table.cell class="text-balance!">{{ $prestamo->motivo}}</flux:table.cell>
                    
                    @role('admin')
                        <flux:table.cell class="text-balance!">{{ $prestamo->trabajador->name }}</flux:table.cell>
                    @endrole
                    @php
                        $color = 'bg-rojo-si!';
                        $textClass = 'text-rojo-negacion!';
                        $hoverClass = 'hover:bg-rojo-negacion! hover:text-white!';

                        if ($dias !== null && $dias <= 5) {
                            $color = 'bg-[#fff1bf]!';
                            $textClass = 'text-[#bb4d00]!';
                            $hoverClass = 'hover:bg-[#FAA543]! hover:text-white!';
                        } 
                        elseif ($dias !== null && $dias <= 10) {
                            $color = 'bg-[#FFE7CD]!';
                            $textClass = 'text-[#CA3500]!';
                            $hoverClass = 'hover:bg-[#FF890A]! hover:text-white!';
                        }
                    @endphp
                    <flux:table.cell>  
                    <flux:button 
                            icon:trailing="eye" 
                            class=" {{$color}} {{$textClass}} font-bold text-sm! border-none!
                            {{$hoverClass}} 
                            transition-all duration-200 ease-out delay-150
                            hover:-translate-y-1.5 active:scale-95 cursor-pointer"
                            href="{{ route('recepcion.show', $prestamo->id) }}"
                            >
                            
                            {{ $dias }} dias
                        </flux:button>
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