@php
    $Prestamo_Activo = $this->conflictosPendientes();
@endphp

    <div class="flex flex-col gap-6">
     {{-- The only way to do great work is to love what you do. - Steve Jobs --}}
        @placeholder
            <x-placeholder.table 
                :header="['Equipo', 'Sicipo', 'Disponibilidad']" />
        @endplaceholder

        @if( $this->SolicitudInfo()->estado === 'Pendiente')
            <flux:callout 
                variant="{{$Prestamo_Activo ? 'warning' : 'success'}}" 
                icon="{{$Prestamo_Activo ? 'exclamation-circle' : 'check-circle'}}" 
                heading="{{$Prestamo_Activo ? 
                            'La solicitud tiene conflictos con otros prestamos' : 
                            'La solicitud no tiene conflictos pendientes'
                        }}" 
                text="{{$Prestamo_Activo ? 
                            'Selecciona una unidad disponible y marca su confirmación para cada equipo en conflicto antes de autorizar.' : 
                            'Todos los equipos solicitados están disponibles o ya tienen un reemplazo confirmado. Puede autorizarse la solicitud.'
                        }}" 
            />
        @endif
        
        <flux:table container:class="max-h-[225px]">
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
                                    {{ $detalle->Unidad_Equipo->sicipo }}
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
            <div class="flex justify-center gap-30 mt-5">               
                
                <flux:modal.trigger name="Confirmar">
                    <x-btn-wire wire="" texto="Aprobar" color="verde_mid" icon="book-up" :disabled="$Prestamo_Activo" />
                </flux:modal.trigger>


                <flux:modal.trigger name="Rechazar">
                    <x-btn-wire wire="" texto="Rechazar" color="rojo_claro" icon="book-alert"/>
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
