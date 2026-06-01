<div class="bg-hueso rounded-xl dark:bg-zinc-900 ">
    <div class="flex flex-row justify-start items-center gap-3 px-10 pt-7">
        <flux:icon name="package" class="w-10 h-10 text-black dark:text-hueso" />
        <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem] dark:text-hueso"> Proximos Prestamos</span>
    </div>
                        
    <div class="pt-3 px-14 pb-6 " >
        <div>
            @placeholder
                <x-placeholder.table :header="['Motivo', 'Solicitante', 'Fecha']" />
            @endplaceholder
            
           <div class="w-full [&_table]:table-fixed">
    <flux:table :paginate="$this->prestamos">
        <flux:table.columns>
            <flux:table.column class="w-[40%]">
                <span class="inline-flex items-center gap-2 whitespace-nowrap text-gris_claro text-base font-semibold">
                    <flux:icon.scroll-text class="text-gris_claro!" />
                    Motivo
                </span> 
            </flux:table.column>

            @role('admin')
                <x-componentes.header_table icon="square-user-round" class="w-[]"> Solicitante </x-componentes.header_table>
            @endrole
            <x-componentes.header_table icon="calendar-clock" class="w-1/4"> Fecha </x-componentes.header_table>    
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($this->prestamos as $prestamo)
                @php
                    $dias = ceil(now()->diffInDays($prestamo->fecha_prestamo));
                @endphp
                <flux:table.row>
                    <flux:table.cell class="text-balance break-words" title="{{ $prestamo->motivo }}">
                        {{ Str::limit($prestamo->motivo, 40) }}
                    </flux:table.cell>

                    @role('admin')
                        <flux:table.cell class="break-words">
                            {{ $prestamo->trabajador->name }}
                        </flux:table.cell>
                    @endrole

                    <flux:table.cell>  
                        @php
                            $texto = match(true){
                                $dias == 0 => 'Hoy',
                                $dias == 1 => 'Mañana',
                                $dias > 1  => "En $dias dias",
                                default    => 'Fecha desconocida'
                            };
                        @endphp
                        <flux:button 
                            icon:trailing="eye" 
                            class="bg-azul-hover! text-azul_oscuro! font-bold text-sm! border-none!
                                dark:bg-azul_oscuro/60! dark:text-azul-hover!
                                   hover:bg-azul_oscuro! hover:text-hueso! 
                                   transition-all duration-200 ease-out delay-150
                                   hover:-translate-y-1.5 active:scale-95 cursor-pointer"
                            href="{{ route('entrega.show', $prestamo->id) }}"
                        >
                            {{ $texto }}
                        </flux:button>
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

        </div>
    </div>
</div>