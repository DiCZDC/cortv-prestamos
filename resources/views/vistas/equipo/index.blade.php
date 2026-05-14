<x-layouts::app :title="__('Equipo')">
    <div class="flex flex-row gap mb-10">
        <div class=" pt-2 w-full gap-6">
            {{-- Cabecera principal --}}
            <div class="flex flex-col justify-center gap-8.5 pl-3 ">
                <x-componentes.titulo icono="airplay" texto="Equipo" />
                <div class="flex w-full justify-between pr-5 ">
                        <x-componentes.subtitulo icono="book-alert" texto="Prestamos pendientes de aprobar" />
                        <flux:modal.trigger name="create-equipo">
                            <flux:button 
                                icon="square-plus" 
                                class=" bg-rojo-si! text-rojo-negacion! font-bold text-sm! border-none!
                                hover:bg-rojo-negacion! 
                                hover:text-hueso! 
                                transition-all duration-200 ease-out delay-150
                                hover:-translate-y-1.5 active:scale-95 cursor-pointer">
                                Añadir un nuevo equipo
                            </flux:button>
                        </flux:modal.trigger>

                </div>
            </div>
        </div>
    </div>
    <div class="w-full not-dark:bg-white rounded-lg not-dark:shadow-md  p-8">
        <livewire:equipo.index.table lazy/>
        {{-- boton  --}}
        <flux:modal name="create-equipo">
            <livewire:equipo.create.form />
        </flux:modal>
    </div>
</x-layouts::app>