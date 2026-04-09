<x-layouts::app :title="__('Equipo')">
    <div class="flex flex-row gap mb-10">
        <div class=" pt-2 w-full gap-6">
            {{-- Cabecera principal --}}
            <div class="flex flex-col justify-center gap-8.5 pl-3 ">
                <x-componentes.titulo icono="airplay" texto="Equipo" />
                <x-componentes.subtitulo icono="database" texto="Equipo registrado" />
            </div>
        </div>
    </div>
    <livewire:equipo.index.table lazy/>
    {{-- boton  --}}
    <div class="flex w-full justify-end mt-4 pr-1">
        <flux:modal.trigger name="create-equipo">
            <flux:button class="!bg-rojo_claro !text-white hover:!bg-rojo_oscuro ">
                <flux:icon name="square-plus" />
                Añadir un nuevo equipo
            </flux:button>
        </flux:modal.trigger>
    </div>
    <flux:modal name="create-equipo">
        <livewire:equipo.create.form />
    </flux:modal>
</x-layouts::app>