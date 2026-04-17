@php
    $producto = App\Models\Equipo::find($id);
@endphp

<x-layouts::app title="Equipo">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('equipo.index') }}">Equipo</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#"> {{ $producto->marca . ' ' . $producto->modelo }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
        <div class="flex flex-col justify-center gap-8.5 pl-3">
            <x-componentes.titulo icono="airplay" texto="Equipo" />
            <x-componentes.subtitulo icono="{{ $producto->categoria->icono }}" texto="{{ $producto->marca . ' ' . $producto->modelo }}" />
        </div>
    <div class="flex gap-12 mt-10">
        <div class="w-2/3 rounded-lg shadow-md p-8 bg-white">
            <livewire:equipo.show.table :id="$id" lazy/>
        </div>
        <div class="w-auto  p-8   ">
            <h1 class="font-bold text-center text-xl text-gris_claro mb-5">Fechas Apartadas</h1>
            <livewire:calendario.multidate_small lazy/>
        </div>
    </div>
</x-layouts::app>
