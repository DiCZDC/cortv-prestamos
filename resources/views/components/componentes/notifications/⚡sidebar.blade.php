<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="w-full">
    <flux:modal.trigger name="notifications-bar">
        <flux:button class="w-full">
                <flux:icon.bell/>
                Notificaciones
        </flux:button>
    </flux:modal.trigger>


    <flux:modal name="notifications-bar" flyout>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    Notificaciones
                </flux:heading>
                <flux:text class="mt-2">
                    Maneja tus notificaciones.
                </flux:text>
            </div>
            
            <flux:button {{ Auth::user()->unreadNotifications->count() === 0 ? 'disabled' : '' }} class="w-full">
                <flux:icon.check-check />
                Marcar todas como leídas
            </flux:button>
            
            <flux:separator />
            
            @forelse (Auth::user()->notifications as $notification)
                <livewire:componentes.notifications.item :key="$notification->id" header="{{ $notification->data['header'] ?? '' }}" subtitle="{{ $notification->data['subtitle'] ?? '' }}" />
            @empty
                <flux:card>
                    <flux:text>
                        No tienes notificaciones.
                    </flux:text>
                </flux:card>
            @endforelse
        </div>
    </flux:modal>
</div>