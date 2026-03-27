@php
    $cant_esperados = App\Models\Solicitud::where('fecha_devolucion','=',now())->count();
    $cant_atrasados = App\Models\Solicitud::where('fecha_devolucion','<',now())->where('estado','=','Entregada')->count();

@endphp
<x-layouts::app :title="__('Recepción')">
    <div class="flex flex-row gap"> 
        <div class=" pt-2 w-1/2 gap-6">
            {{-- Cabecera principal --}}
            <div class="mb-4 flex items-center gap-6 text-rojo_claro">
                <flux:icon name="truck" class="inline h-15 w-15" />
                <span class="ml-2 text-5xl font-semibold">
                    {{ __('Recepción de prestamos') }}
                </span>
            </div>
            <div class="mb-2 flex items-center text-gris_claro align-middle gap-7">
                <flux:icon name="database" class="inline h-10 w-10" />
                <span class="text-[30px] -tracking-tighter text-gris_claro font-inter" style="font-style: normal;">
                    {{ __('Devoluciones de productos.') }}
                </span>
            </div>
        </div>
        <div class="w-2/5 flex justify-between items-center ">
            <livewire:card titulo='{{$cant_esperados}} equipos' descripcion='esperados hoy' icono='inbox' color_text='black'/>    
            <livewire:card titulo='{{$cant_atrasados}} Prestamos' descripcion='atrasados' icono='clock' color_text='black'/>    
        
        </div>
    </div>  
    <div class="mt-10">
        @livewire('recepcion.table')
    </div>
</x-layouts::app>