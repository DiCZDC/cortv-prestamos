@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $hoy = now();

    function subMonth()
    {
        $this->hoy = $this->hoy->subMonth();
    }

    function addMonth()
    {
        $this->hoy = $this->hoy->addMonth();
    }

@endphp
<x-layouts::app :title="__('Calendario')">
    <div class=" pt-2 w-full gap-6">
        {{-- Cabecera principal --}}
        <div class="flex flex-col justify-center gap-8.5 pl-3 mb-8 ">
            <x-componentes.titulo icono="calendar-days" texto="Calendario" />
            <x-componentes.subtitulo class="w-full" icono="box" texto="Prestamos y Recepciones Este Mes" />
        </div>
    </div>

    <div class="flex flex-col justify-center items-center">
        {{-- <div class="flex justify-center items-center gap-5 mb-2 text-rojo_claro">
            <flux:button icon="chevron-left" wire:click="subMonth"/>
            <h1 class="text-6xl">
                {{ $meses[$hoy->month - 1] }} {{ $hoy->year }}
            </h1>
            <flux:button icon="chevron-right" wire:click="addMonth"/>
        </div> --}}
        <div >
            <livewire:calendario_admin 
                initial-year="{{ $hoy->year }}"
                initial-month="{{ $hoy->month }}"
            />
        </div>
    </div>

</x-layouts::app>
