<x-layouts::app :title="__('Archivo')">
    <div class=" pt-2 w-full gap-6">
        {{-- Cabecera principal --}}
        <div class="flex flex-col justify-center gap-8.5 pl-3 mb-8 ">
            <x-componentes.titulo icono="archive" texto="Archivo de Prestamos" />
            <x-componentes.subtitulo class="w-full" icono="database" texto="Prestamos resueltos" />
        </div>
    </div>
    <livewire:archivo.index.table lazy/>
    {{-- @role('admin')
    @elserole('trabajador')
    @endrole --}}
</x-layouts::app>