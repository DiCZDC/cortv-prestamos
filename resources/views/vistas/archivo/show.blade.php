@php
    $Solicitud = App\Models\Solicitud::find($id);
@endphp

<x-layouts::app title="Archivo">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('archivo.index') }}">Archivo</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">{{ $Solicitud->motivo. ' - ' . $Solicitud->fecha_prestamo }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col items-start justify-center gap-4 pt-1 mb-4">               
            <div class="flex flex-col items-start justify-center gap-7 pl-3  ">               
                <x-componentes.titulo icono="book-marked" texto="Detalles del prestamo" />
                <x-componentes.subtitulo icono="square-user-round" texto=" {{ __('Solicitado por:') }} {{ $Solicitud->trabajador->name }}" />
            </div> 
            <div class="pl-3 mt-2">
                <x-componentes.subtitulo icono="shield-user" texto=" {{ __('Autorizado por:') }} {{ $Solicitud->admin->name }}" />
            </div>
    </div>
    
    <div class="w-full flex justify-around">
        <div class="bg-white rounded-lg shadow-md  flex flex-col gap-3 px-5 py-7 w-1/2">
                <div class="inline-flex items-center text-gris_claro gap-3 ml-5">
                    <flux:icon.clipboard-paste class="size-10" />
                    <span class="font-medium text-3xl">Equipo Solicitado</span>  
                </div>
                <div class="px-10 w-full">
                    <livewire:archivo.show.table :solicitudId="$id" lazy/>
                </div>
        </div>
        <div class=" flex items-center justify-center">
            <livewire:calendario.small :id="$id" lazy/>
        </div>
    </div>


</x-layouts>
