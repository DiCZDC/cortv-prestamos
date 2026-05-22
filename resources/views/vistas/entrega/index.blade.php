<x-layouts::app title="Entregas">
    <div class="
    {{-- px-2 --}}
    lg:px-6 flex flex-col gap-8
    
    bg-red-700
    ">
        {{-- info de la vista --}}
        <div class="w-full flex 
            flex-col
            justify-between 
            md:flex-row
        ">

            <div class="flex flex-col justify-center gap-8.5 pl-3 ">      
                <x-componentes.titulo icono="package" texto="Entregas" />
                <x-componentes.subtitulo icono="boxes" texto="Entregas pendientes de realizar" />
    
            </div>
        
            <div >
                @php
                    $prestamos_pendientes = App\Models\Solicitud::where('estado', 'Autorizada')
                    ->where('fecha_prestamo', '<=', now())
                    ->count();
                @endphp
                   
                   <livewire:componentes.card titulo="{{ $prestamos_pendientes }} Prestamos" 
                    descripcion='Pendientes de entrega' icono='package-search' color_text='text-black' color_bg='bg-hueso'/>    
            </div>
        
        </div>


        <div class="w-full not-dark:bg-white rounded-lg not-dark:shadow-md  p-8">
            <livewire:entrega.index.table lazy/> 
        </div>
    </div>
</x-layouts::app >