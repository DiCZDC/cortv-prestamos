<x-layouts::app :title="__('Personal')">
    <div class=" px-6 w-full gap-10 flex flex-col">
            {{-- Cabecera principal --}}
            <div class="flex flex-col justify-center gap-8 pl-3 pt-5">
                <x-componentes.titulo icono="book-user" texto="Gestión del personal" />
                <x-componentes.subtitulo icono="database-zap" texto="Personal registrado" />
            </div>
            
            <div class="w-full not-dark:bg-white rounded-lg not-dark:shadow-md  p-8">
                <livewire:personal.index.table lazy/>
            </div>
    </div>
</x-layouts::app>