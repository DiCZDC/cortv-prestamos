@php
    $Prestamo_Activo = $this->conflictosPendientes();
@endphp

<div class="flex flex-col gap-6">

    <div>
        <flux:callout 
            variant="{{$Prestamo_Activo ? 'warning' : 'success'}}" 
            icon="{{$Prestamo_Activo ? 'exclamation-circle' : 'check-circle'}}" 
            heading="{{$Prestamo_Activo ? 
                        'La solicitud tiene conflictos con otros prestamos' : 
                        'La solicitud no tiene conflictos pendientes'
                    }}" 
            text="{{$Prestamo_Activo ? 
                        'Selecciona una unidad disponible y marca su confirmación para cada equipo en conflicto antes de autorizar.' : 
                        'Todos los equipos solicitados están disponibles o ya tienen un reemplazo confirmado.'
                    }}" 
        />
    </div>

    <div class="bg-white rounded-lg shadow-md px-5 py-6.5 flex flex-col dark:bg-transparent">
        
        <div class="inline-flex items-center text-gris_claro gap-2 ml-5 ">
                        <flux:icon.clipboard-paste class="size-8" />
                        <span class="font-bold 
                        text-xl
                        md:text-2xl">Resumen de la solicitud</span>  
        </div>
        
        <div class="flex flex-col px-5 py-3 h-9/10">
        {{-- The only way to do great work is to love what you do. - Steve Jobs --}}
            
                @placeholder
                    <x-placeholder.table 
                        :header="['Equipo', 'Sicipo', 'Disponibilidad']" />
                @endplaceholder

                
                <flux:table container:class="max-h-[240px]">
                    <flux:table.columns sticky class="bg-white dark:bg-[#262626]">
                        <x-componentes.header_table icon="hard-drive"> Equipo </x-componentes.header_table> 
                        <x-componentes.header_table icon="binary"> Sicipo </x-componentes.header_table> 
                        <x-componentes.header_table icon="chart-no-axes-column-increasing"> Disponibilidad </x-componentes.header_table>
                        
                    </flux:table.columns>
                    <flux:table.rows>
                        @forelse ($this->detalles as $detalle)
                            <flux:table.row>
                                <flux:table.cell>
                                    {{ $detalle->Unidad_Equipo->Equipo->marca }} {{ $detalle->Unidad_Equipo->Equipo->modelo }}
                                </flux:table.cell>
                                <flux:table.cell>
                                    @php
                                        $estadoBadgeDisponible = $detalle->Disponible;
                                    @endphp
                                        @if ($detalle->Disponible)
                                             <flux:badge color="blue" class="text-azul_oscuro! ">{{ $detalle->Unidad_Equipo->sicipo }} </flux:badge>       
                                        @else
                                            @php
                                                $equiposDisponibles = $this->equipos_libres($detalle->Unidad_Equipo->Equipo->id);
                                                $unidadSeleccionada = (int) ($this->unidadesSeleccionadas[$detalle->id] ?? $detalle->Unidad_Equipo->id);
                                                $seleccionValida = $equiposDisponibles->pluck('id')->contains($unidadSeleccionada)
                                                    && $unidadSeleccionada !== (int) $detalle->Unidad_Equipo->id;
                                                $estadoBadgeDisponible = $seleccionValida;
                                            @endphp

                                            <div class="flex items-center gap-3 max-sm:flex-col max-sm:items-start">
                                                <div class="w-full">
                                                    
                                                    <flux:select wire:model.live="unidadesSeleccionadas.{{ $detalle->id }}" 
                                                        wire:key="selector-unidad-{{ $detalle->id }}" :disabled="$this->solicitudInfo()->estado !== 'Pendiente'">
                                                        <flux:select.option value="{{ $detalle->Unidad_Equipo->id }}">
                                                            {{ $detalle->Unidad_Equipo->sicipo }} (actual)
                                                        </flux:select.option>

                                                        @forelse ($equiposDisponibles as $unidad)
                                                            <flux:select.option value="{{ $unidad->id }}">{{ $unidad->sicipo }}</flux:select.option>
                                                        @empty
                                                            <flux:select.option disabled>No hay unidades disponibles</flux:select.option>
                                                        @endforelse
                                                    </flux:select>
                                                
                                                </div>

                                                <flux:field variant="inline" class="shrink-0">
                                                    <flux:checkbox
                                                        wire:model.live="detallesConfirmados.{{ $detalle->id }}"
                                                        :disabled="!$seleccionValida"
                                                        wire:key="confirmacion-unidad-{{ $detalle->id }}"
                                                    />
                                                    <flux:label>Confirmar</flux:label>
                                                </flux:field>
                                            </div>
                                        @endif
                                </flux:table.cell>
                                <flux:table.cell class="px-15!" >
                                    <flux:badge color="{{$estadoBadgeDisponible ? 'green' : 'red'}}" class="text-sm!">
                                        {{$estadoBadgeDisponible ? 'Disponible' : 'No disponible'}}
                                    </flux:badge>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty

                            <flux:table.row>
                                <flux:table.cell colspan="3" class="text-center py-4">
                                    No hay detalles disponibles.
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
                
                @if($this->SolicitudInfo()->estado === 'Pendiente')
                    <div class="flex justify-around mt-5">               
                        
                        <flux:modal.trigger name="Confirmar">
                            <flux:button 
                                :disabled="$Prestamo_Activo"
                                icon="book-up" 
                                class=" bg-[#f0fdf4]! text-[#00a661]! font-bold text-sm! border-none!
                                hover:bg-[#00a661]! 
                                hover:text-[#f0fdf4]! 
                                transition-all duration-200 ease-out delay-100
                                hover:-translate-y-1.5 active:scale-95 cursor-pointer">
                                Aprobar
                            </flux:button>
                        </flux:modal.trigger>

                        <flux:modal.trigger name="Rechazar">
                            <flux:button 
                                icon="book-alert" 
                                class=" bg-rojo-si! text-[#c10007]! font-bold text-sm! border-none!
                                hover:bg-[#c10007]! 
                                hover:text-hueso! 
                                transition-all duration-200 ease-out delay-100
                                hover:-translate-y-1.5 active:scale-95 cursor-pointer">
                                Rechazar
                            </flux:button>
                        </flux:modal.trigger>   
                    
                    </div>
                @else
                
                    @if($this->SolicitudInfo()->estado === 'Autorizada')
                    <div class="flex justify-center mt-5">
                        <flux:button disabled variant="primary" icon="clipboard-check" class="w-9/10 !bg-verde_mid border-none !text-white">Solicitud Aprobada</flux:button>
                    </div>
                    @else
                    <div class="flex justify-center mt-5">
                        <flux:button disabled variant="primary" icon="book-x" class="w-9/10 !bg-rojo_claro border-none !text-white">Solicitud Rechazada</flux:button>
                    </div>
                    @endif
                @endif    
                    
            </div>
            
            <flux:modal name="Confirmar" class="min-w-[22rem]">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Aprobar solicitud</flux:heading>
                        <flux:text class="mt-2">
                            Estás a punto de aprobar esta solicitud.<br>
                            Esta acción no se puede deshacer.
                        </flux:text>
                    </div>
                    
                    <div class="flex flex-row-reverse justify-around">
                        {{-- <flux:spacer /> --}}
                        <flux:modal.close>
                            <flux:button>Regresar</flux:button>
                        </flux:modal.close>
                        
                        <flux:modal.close>
                            <x-btn-wire wire="autorizar" texto="Aprobar" color="verde_mid" icon="book-lock" :disabled="$Prestamo_Activo" />
                        </flux:modal.close>
                    </div>
                </div>
            </flux:modal>

            <flux:modal name="Rechazar" class="min-w-[22rem]">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Rechazar solicitud</flux:heading>
                        <flux:text class="mt-2">
                            Estás a punto de rechazar esta solicitud.<br>
                            Esta acción no se puede deshacer.
                        </flux:text>
                    </div>
                    
                    <div class="flex justify-around">
                        <flux:modal.close>
                            <flux:button >Regresar</flux:button>
                        </flux:modal.close>
                        
                        <flux:modal.close>
                            <x-btn-wire wire="rechazar" texto="Rechazar" color="rojo_claro" icon="book-x" />
                        </flux:modal.close>
                    </div>
                </div>
            </flux:modal>
    
</div>