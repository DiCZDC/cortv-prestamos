<x-layouts::app :title="__('Prestamos')">
    <div class=" pt-2 w-3/4 gap-6">
        {{-- Cabecera principal --}}
        <div class="mb-4 flex items-center gap-6 text-rojo_claro">
            <flux:icon name="file" class="inline h-15 w-15" />
            <span class="ml-2 text-5xl font-semibold">
                {{ __('Prestamos Activos/Pendientes') }}
            </span>
        </div>
        <div class="mb-2 flex items-center text-gris_claro align-middle gap-7">
            <flux:icon name="database" class="inline h-10 w-10" />
            <span class="text-[30px] -tracking-tighter text-gris_claro font-inter" style="font-style: normal;">
                {{ __('Solicitud de prestamos') }}
            </span>
        </div>
    </div>
    @livewire('prestamos.table')

</x-layouts::app>
