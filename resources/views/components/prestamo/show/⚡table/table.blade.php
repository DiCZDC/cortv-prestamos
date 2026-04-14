@php
    $Prestamo_Activo = $this->detalles()->pluck('Disponible')->contains(false);
@endphp

<form wire:submit="actualizar">
    <div class="flex flex-col gap-6">
     {{-- The only way to do great work is to love what you do. - Steve Jobs --}}
        @placeholder
            <x-placeholder.table 
                :header="['Fecha Préstamo', 'Sicipo', 'Disponibilidad']" />
        @endplaceholder

        @if( $this->SolicitudInfo()->estado === 'Pendiente')
            <flux:callout 
                variant="{{$Prestamo_Activo ? 'warning' : 'success'}}" 
                icon="{{$Prestamo_Activo ? 'exclamation-circle' : 'check-circle'}}" 
                heading="{{$Prestamo_Activo ? 
                            'La solicitud tiene conflictos con otros prestamos' : 
                            'La solicitud no tiene conflictos con otros préstamos'
                        }}" 
                text="{{$Prestamo_Activo ? 
                            'Resuelve los conflictos antes de autorizar la solicitud.' : 
                            'Todos los equipos solicitados están disponibles. Puede autorizarse de manera inmediata la solicitud.'
                        }}" 
            />
        @endif
        <flux:table container:class="max-h-[225px]">
            <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
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
                            {{ $detalle->Unidad_Equipo->sicipo }}
                        </flux:table.cell>
                        <flux:table.cell class="!px-15" >
                            <flux:badge color="{{$detalle->Disponible ? 'green' : 'red'}}" class="!text-sm">
                                {{$detalle->Disponible ? 'Disponible' : 'No disponible'}}
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
            <div class="flex align-middle justify-evenly mt-5">               
                @if(!$Prestamo_Activo)
                <x-componentes.btnsformulario 
                type="submit" texto="Aprobar" color="verde_mid" icon="clipboard-check" />
                <x-componentes.btnsformulario type="button" texto="Rechazar" color="rojo_claro" icon="circle-x" />  
                
                @endif
            </div>
        @endif
    
    </div>
</form>