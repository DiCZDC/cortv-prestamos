<?php

use Livewire\Component;

new class extends Component
{
    #[On('notifications-updated')]
    public function updateNotifications()
    {
        $this->dispatch('$refresh');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
};
?>

<div class="w-full">
    <flux:modal.trigger name="notifications-bar">
        <flux:button class="w-full">
                @if (Auth::user()->unreadNotifications()->count() != 0)
                    <flux:icon.bell-dot class="text-rojo-texto"/>
                @else
                    <flux:icon.bell/>    
                @endif
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
            
            <flux:button :disabled="Auth::user()->unreadNotifications->count() === 0" 
                class="w-full"
                wire:click="markAllAsRead"    
                >
                <div class="flex flew-row items-center justify-center gap-2">
                    <flux:icon.check-check />
                    Marcar todas como leídas
                </div>
            </flux:button>
            <div class="w-full flex items-center justify-between"> 
                <flux:text>
                    Tienes: <b>{{ Auth::user()->unreadNotifications->count() }}</b> notificaciones pendientes.
                </flux:text>
                <flux:button wire:click="$refresh" variant="ghost" size="sm">
                    <flux:icon.rotate-ccw />        
                </flux:button>
            </div>
            <flux:separator />
            
            <div wire:poll.30s class="gap-3"> 
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