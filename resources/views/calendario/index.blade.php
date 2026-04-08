@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

@endphp
<x-layouts::app :title="__('Calendario')">
    <div class=" pt-2 w-full gap-6">
        {{-- Cabecera principal --}}
        <div class="flex flex-col justify-center gap-8.5 pl-3 mb-8 ">
            <x-componentes.titulo icono="calendar-days" texto="Calendario" />
            <x-componentes.subtitulo class="w-full" icono="box" texto="Prestamos y Recepciones en {{ $meses[now()->month - 1] }} {{ now()->year }}" />
        </div>
    </div>

    <div class="flex flex-col justify-center items-center">
        <div >
            <livewire:calendario_admin lazy 
                initial-year="{{ now()->year }}"
                initial-month="{{ now()->month }}"
            />
        </div>
    </div>

</x-layouts::app>
