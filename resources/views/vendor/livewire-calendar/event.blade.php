<div
    @if($eventClickEnabled)
        wire:click.stop="onEventClick('{{ $event['id']  }}')"
    @endif

    class="bg-hueso dark:bg-[#4242428a] rounded-lg border py-2 px-3 shadow-md cursor-pointer">
    
    <flux:badge
        size="sm"
        :color="$event['estado'] === 'Autorizada' ? 'green' 
        : ($event['estado'] === 'Entregada' ? 'cyan' 
        : ($event['estado'] === 'Pendiente' ? 'yellow' 
        :($event['estado'] === 'Rechazada' ? 'red' : 'blue')))"
        inset="top bottom"
        >
        {{$event['estado'] ?? 'Sin estado'}}
    </flux:badge>

    <p class="mt-2 text-xs">
        {{ $event['description'] ?? 'No description' }}
    </p>
    <p class="text-sm font-medium">
        {{ $event['title'] }}
    </p>
</div>
