<x-layouts::app :title="__('Equipo')">
    <div class="flex flex-row gap mb-10">
        <div class=" pt-2 w-3/4 gap-6">
            {{-- Cabecera principal --}}
            <div class="flex flex-col justify-center gap-8.5 pl-3 ">
                <x-componentes.titulo icono="airplay" texto="Equipo" />
                <x-componentes.subtitulo icono="database" texto="Equipo registrado" />
            </div>
        </div>
    </div>

    @livewire('equipo.table')
</x-layouts::app>