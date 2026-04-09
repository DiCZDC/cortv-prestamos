<form wire:submit="actualizar">
<div class="flex flex-col gap-6">
     {{-- The only way to do great work is to love what you do. - Steve Jobs --}}

    {{-- The only way to do great work is to love what you do. - Steve Jobs --}}
    @placeholder
        <x-placeholder.table 
            :header="['Fecha Préstamo', 'Sicipo', 'Disponibilidad']" />
    @endplaceholder
    
    @if ($this->verificar_unidades_equipo()->isNotEmpty())
     
        <flux:callout variant="warning" icon="exclamation-circle" heading="Please verify your account to unlock all features." />

    @else
    
    <flux:callout variant="success" icon="check-circle" heading="La solicitud no tiene conflictos con otros préstamos" text="Todos los equipos solicitados están disponibles.
    Puede autorizarse de manera inmediata la solicitud." />
         
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
                        {{-- {{ $detalle->Unidad_Equipo->Equipo->id}} --}}
                        {{ $this->solicitud($detalle->Unidad_Equipo->Equipo->id) ? 'Disponible' : 'Equipo no disponible' }}
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

    <div class="flex align-middle justify-evenly mt-5">
        <x-componentes.btnsformulario type="submit" texto="Aprobar" color="verde_mid" icon="clipboard-check" />
        <x-componentes.btnsformulario type="button" texto="Rechazar" color="rojo_claro" icon="circle-x" />  
    </div>
</div>
</form>