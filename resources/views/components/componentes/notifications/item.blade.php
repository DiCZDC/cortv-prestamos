<?php

use Livewire\Component;

new class extends Component
{

    public $notification;


    public function markAsRead()
    {
        $this->notification->markAsRead();
        $this->dispatch('notifications-updated');
    }
};
?>

<div>
    <flux:card>
        <div class="flex flex-row items-start space-x-4">
            <flux:avatar 
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
                size="md" 
                color="auto"
                color:seed={{ auth()->user()->id }}

            />
            <div class="flex flex-col items-start gap-4 w-full max-w-xs">
                <div class="min-w-0 flex-1">
                    <div class= "flex items-center justify-between gap-2 mb-2">
                        <flux:heading size="sm">
                            {{ $notification->data['header'] ?? 'Sin título' }}
                        </flux:heading>
                        <flux:badge color="lime" size="sm">
                            {{ $notification->created_at->locale('es')->diffForHumans() }}
                        </flux:badge>
                    </div>
                    <flux:text class="text-justify">
                        {{ $notification->data['subtitle'] ?? 'Sin subtítulo' }}
                    </flux:text>
                </div>
                
                <div class="flex flex-row gap-4">
                    <flux:button wire:click="markAsRead" href="{{ $notification->data['url'] ?? '#' }}" target="_blank">
                        Ver detalles
                    </flux:button>
                    <flux:button wire:click="markAsRead" wire:loading.attr="disabled">
                        Marcar como leído
                    </flux:button>
                </div>
            </div>
        </div>
    </flux:card>
</div>