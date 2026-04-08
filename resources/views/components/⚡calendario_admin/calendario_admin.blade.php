
<div>
    <div class="flex justify-center items-center gap-5 mb-2 text-rojo_claro">
            <flux:button icon="chevron-left" wire:click="subMonth"/>
            <h1 class="text-6xl">
                {{ $meses[$hoy->month - 1] }} {{ $hoy->year }}
            </h1>
            <flux:button icon="chevron-right" wire:click="addMonth"/>
        </div>
</div>