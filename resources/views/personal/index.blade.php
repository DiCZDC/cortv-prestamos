<x-layouts::app :title="__('Personal')">
    <div class=" pt-2 w-full gap-6 mb-10">
            {{-- Cabecera principal --}}
            <div class="flex flex-col justify-center gap-8.5 pl-3 ">
                <x-componentes.titulo icono="users" texto="Gestión del personal" />
                <x-componentes.subtitulo icono="database" texto="Personal registrado" />
            </div>
        </div>
        @livewire('personal.table')
</x-layouts::app>