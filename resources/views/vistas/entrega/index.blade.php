<x-layouts::app title="Entregas">
    <div class="px-4">
        {{-- info de la vista --}}
        <div class="flex flex-col justify-center gap-8.5 pl-3 mb-8">
            
            <x-componentes.titulo icono="file" texto="Entregas" />
            <x-componentes.subtitulo icono="book-alert" texto="Entregas pendientes de realizar" />

        </div>
        <div class="w-full not-dark:bg-white rounded-lg not-dark:shadow-md  p-8">
            <livewire:entrega.index.table lazy/> 
        </div>
    </div>
</x-layouts::app >