<x-layouts::app title="Entregas">
    <div class=" py-3.5 
    lg:px-6 flex flex-col gap-8
    ">
        {{-- info de la vista --}}
        <div class="w-full flex flex-col gap-6 sm:gap-0 sm:justify-between sm:flex-row">

            <div class="flex flex-col justify-center gap-6 pl-3 ">      
                <x-componentes.titulo icono="package" texto="Entregas" />
                <x-componentes.subtitulo icono="boxes" texto="Entregas pendientes de realizar" />
    
            </div>
        
            <div class="self-center sm:self-auto">
                @php
                    $prestamos_pendientes = App\Models\Solicitud::where('estado', 'Autorizada')
                    ->where('fecha_prestamo', '<=', now())
                    ->count();
                @endphp
                   
                   <livewire:componentes.card titulo="{{ $prestamos_pendientes }} Prestamos" 
                    descripcion='Pendientes de entrega' icono='package-search' color_text='text-black' color_bg='bg-hueso'/>    
            </div>
        
        </div>


        <div class="w-full not-dark:bg-white rounded-lg not-dark:shadow-md  px-8 pt-8 pb-2">
            <livewire:entrega.index.table lazy/> 
        </div>
    </div>
</x-layouts::app >