@php
    $cant_esperados = App\Models\Solicitud::where('fecha_devolucion','=',now())->count();
    $cant_atrasados = App\Models\Solicitud::where('fecha_devolucion','<',now())->where('estado','=','Entregada')->count();

@endphp
<x-layouts::app :title="__('Recepción')">
    <div class="flex flex-col px-6 pb-2">
        <div class="flex flex-col gap justify-between gap-8.5 
            align-middle items-center
            lg:flex-row 
        "> 
            
            {{-- Cabecera principal --}}
            <div class="flex flex-col pt-2 w-auto gap-8 pl-3    
            ">
                <x-componentes.titulo icono="truck" texto="Recepción de Prestamos" />
                <x-componentes.subtitulo icono="package-open" texto="Devoluciones de productos" />
            </div>

            
            <div class="w-full flex-col flex justify-between items-center gap-8.5   
                md:justify-evenly
                lg:w-[40%] md:flex-row 
            ">
                <livewire:componentes.card titulo='{{$cant_esperados}} equipos' descripcion='esperados hoy' icono='hard-drive-download' color_text='black' color_bg='bg-white'/>    
                <livewire:componentes.card titulo='{{$cant_atrasados}} Prestamos' descripcion='atrasados' icono='file-clock' color_text='black' color_bg='bg-white'/>    
            
            </div>
        </div>
        
            <div class="mt-10 w-full not-dark:bg-white rounded-lg not-dark:shadow-md  p-8">
                <livewire:recepcion.index.table lazy />
            </div>
    </div>
</x-layouts::app>