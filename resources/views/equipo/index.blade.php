<x-layouts::app :title="__('Equipo')">
    <div class="flex flex-row">
        <div class=" w-3/4">
            {{-- Cabecera principal --}}
            <div class="mb-2 flex items-center gap-6 text-rojo_claro">
                <flux:icon name="airplay" class="inline h-10 w-10" />
                <span class="ml-2 text-5xl font-semibold">
                    {{ __('Equipo') }}
                </span>
            </div>
            <div>
                <flux:icon name="database" class="inline h-6 w-6" />
                <span class="text-sm text-muted-foreground">
                    {{ __('Equipo registrado.') }}
                </span>
            </div>
        </div>
        <div class="bg-amarillo_logo w-1/4">
            HOLA
        </div>
    </div>

    @livewire('equipo.table')
</x-layouts::app>