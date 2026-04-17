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
            
            <flux:button class="w-full">
                <flux:icon.check-check />
                Marcar todas como leídas
            </flux:button>

            <flux:separator />
            
            @for($i = 0; $i < 5; $i++)
                <livewire:componentes.notifications.item :key="$i" />
            @endfor
        </div>
    </flux:modal>
</div>