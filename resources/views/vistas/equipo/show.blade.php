@php
    $producto = App\Models\Equipo::find($id);
@endphp

<x-layouts::app title="Equipo">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('equipo.index') }}">Equipo</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#"> {{ $producto->marca . ' ' . $producto->modelo }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
        <div class="flex flex-col justify-center gap-8.5 pl-3 ">
            <x-componentes.titulo icono="airplay" texto="Equipo" />
            <x-componentes.subtitulo icono="database" texto="{{ $producto->marca . ' ' . $producto->modelo }}" />
        </div>
    <div class="flex gap-12">
        <div class="w-2/3 rounded-lg shadow-md p-8 mt-10">
            <livewire:equipo.show.table :id="$id" lazy/>
        </div>
        <div class="w-1/3 rounded-lg shadow-md p-8 mt-10">
            <h1 class="font-bold text-xl text-gris_claro mb-5">Fechas Apartadas</h1>
            aka ba el otro kandelario
            {{-- <livewire:calendario.small lazy/> --}}
        </div>
    </div>
</x-layouts::app>
