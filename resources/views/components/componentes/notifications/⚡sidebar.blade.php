<?php

use Livewire\Component;

new class extends Component
{
    #[On('notifications-updated')]
    public function updateNotifications()
    {
        $this->dispatch('$refresh');
    }

    #[On('notifications-updated')]
    public function reloadNotifications()
    {
        $this->skipRender();
    }
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
            {{-- Corregir esto --}}
            <flux:button :disabled="Auth::user()->unreadNotifications->count() === 0" class="w-full">
                <flux:icon.check-check />
                Marcar todas como leídas
            </flux:button>
            
            <flux:separator />
            
            <div wire:poll.30s >
                @php($unreadNotifications = Auth::user()->fresh()->unreadNotifications()->latest()->get())
                @forelse ($unreadNotifications as $notification)
                    <livewire:componentes.notifications.item
                        :key="'notification-'.$notification->id.'-'.optional($notification->updated_at)->timestamp"
                        :notification="$notification"
                    />
                @empty
                    <flux:card>
                        <flux:text>
                            No tienes notificaciones.
                        </flux:text>
                    </flux:card>
                @endforelse
            </div>
        </div>
    </flux:modal>
</div>