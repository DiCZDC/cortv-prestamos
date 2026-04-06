@php
    $Solicitud = \App\Models\Solicitud::find($id);
@endphp

<x-layouts::app title="Mostrar Préstamo">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('prestamo.index') }}">Archivo</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">{{ $Solicitud->motivo. ' - ' . $Solicitud->fecha_prestamo }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    {{-- header --}}
    <div class="flex w-full pr-5 justify-between mb-4 ">
        {{-- info de la vista --}}
        <div class="flex flex-col justify-center gap-8.5 pl-3 ">
            <div class="flex items-center gap-3 text-rojo_claro">
                <flux:icon name="file" class="inline size-13" />
                <h1 class="text-5xl font-bold inline">
                    Detalles de la solicitud
                </h1>
            </div>
            <div class="flex items-center gap-3 text-gris_claro pl-1.5">
                <flux:icon name="airplay" class="inline size-9" />
                <span class="text-2xl text-gris_claro font-semibold " >
                    {{ __('Equipo solicitado para:') }} {{ $Solicitud->motivo }}
                </span>
            </div>
        </div>
    </div>
    <div class="flex flex-row gap-20">
        <div class="w-1/2 rounded-lg shadow-md p-8">
            <livewire:prestamo.tabla_detalles :solicitudId="$id" lazy/>
            {{-- @livewire('prestamo.tabla_detalles', ['solicitudId' => $id]) --}}
        </div>
        <div class="flex flex-col">
            <div class="flex items-center gap-3 text-rojo_claro mt-8">
                Aki ba el candelario
                <flux:text>
                    Periodo de prestamo
                </span>
            </div>
            <div>
               <livewire:card
                :titulo="'Asignar equipos'"
                :descripcion="'Selecciona los equipos que deseas asignar a esta solicitud'"
                :icono="'thumbs-up'"
                :color_bg="'bg-verde_mid'"
                :color_text="'text-hueso'"
               />
            </div>
        </div>
    </div>
</x-layouts::app >
