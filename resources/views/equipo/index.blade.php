<x-layouts::app :title="__('Equipo')">
    <div class="flex flex-row gap mb-10">
        <div class=" pt-2 w-3/4 gap-6">
            {{-- Cabecera principal --}}
            <div class="mb-4 flex items-center gap-6 text-rojo_claro">
                <flux:icon name="airplay" class="inline h-15 w-15" />
                <span class="ml-2 text-5xl font-semibold">
                    {{ __('Equipo') }}
                </span>
            </div>
            <div class="mb-2 flex items-center text-gris_claro align-middle gap-7">
                <flux:icon name="database" class="inline h-10 w-10" />
                <span class="text-[30px] -tracking-tighter text-gris_claro font-inter" style="font-style: normal;">
                    {{ __('Equipo registrado.') }}
                </span>
            </div>
        </div>
    </div>

    @livewire('equipo.table')
</x-layouts::app>