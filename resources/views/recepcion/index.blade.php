@php
    $cant_esperados = App\Models\Solicitud::where('fecha_devolucion','=',now())->count();
    $cant_atrasados = App\Models\Solicitud::where('fecha_devolucion','<',now())->where('estado','=','Entregada')->count();

@endphp
<x-layouts::app :title="__('Recepción')">
    <div class="flex flex-col-reverse gap justify-between gap-8.5
        md:flex-row 
    "> 
        
        
        {{-- Cabecera principal --}}
        <div class="flex flex-col justify-between pt-2 w-auto gap-8.5 pl-3 ">
            <x-componentes.titulo icono="truck" texto="Recepción de Prestamos" />
            <x-componentes.subtitulo icono="database" texto="Devoluciones de productos" />
        </div>

        
        <div class="w-full flex-col flex justify-between items-center gap-8.5
            lg:w-[40%] lg:flex-row 
        ">
            <livewire:card titulo='{{$cant_esperados}} equipos' descripcion='esperados hoy' icono='inbox' color_text='black'/>    
            <livewire:card titulo='{{$cant_atrasados}} Prestamos' descripcion='atrasados' icono='clock' color_text='black'/>    
        
        </div>
    </div>  
    <div class="mt-10">
        @livewire('recepcion.table')
    </div>
</x-layouts::app>