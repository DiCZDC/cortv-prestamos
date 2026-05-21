@php
    $producto = App\Models\Equipo::find($id);
    $unidad = '';
@endphp

<x-layouts::app title="Equipo">
    <div class="px-10 py-3 w-full gap-6 flex flex-col">

        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('equipo.index') }}">Equipo</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#"> {{ $producto->marca . ' ' . $producto->modelo }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->

        <div class="flex flex-col justify-center gap-8.5 pl-3">
            <x-componentes.titulo icono="{{ $producto->categoria->icono }}" texto="{{ $producto->marca . ' ' . $producto->modelo }}" />
            <x-componentes.subtitulo icono="list-ordered" texto="Unidades totales del equipo registradas" />
        </div>

        <div class="flex gap-12 mt-6 flex-col lg:flex-row ">
            <div class="w-full lg:w-2/3 rounded-lg shadow-md p-8 bg-white dark:bg-transparent">
                <div class="w-full flex items-center justify-end mb-3">
                    <flux:modal.trigger name="create-unidad">
                        <flux:button 
                            icon="book-up" 
                            class=" bg-rojo-si! text-rojo-negacion! font-bold text-sm! border-none!
                            hover:bg-rojo-negacion! 
                            hover:text-hueso! 
                            transition-all duration-200 ease-out delay-150
                            hover:-translate-y-1.5 active:scale-95 cursor-pointer">
                            Agregar una nueva unidad
                        </flux:button>
                    </flux:modal.trigger>
                </div>
                <livewire:equipo.show.table :id="$id" lazy/>
            </div>
            <div class="flex flex-col w-auto  p-8 items-center justify-center  ">
                <h1 class="font-bold text-center text-xl text-gris_claro mb-5 
                    dark:text-hueso
                ">
                    Fechas Apartadas
                </h1>
                <livewire:calendario.multidate_small :id_equipo="$id" lazy/>
            </div>
        </div>
    </div>

    <livewire:equipo.show.agregar_unidades :producto="$producto"/>
</x-layouts::app>
