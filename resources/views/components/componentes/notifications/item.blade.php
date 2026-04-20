<?php

use Livewire\Component;

new class extends Component
{
    public $header = 'This is a notification message.';
    public $subtitle = 'This is the subtitle for the notification message.';
};
?>

<div>
    <flux:card>
        <div class="flex items-start space-x-4">
            <flux:avatar 
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
                size="md" 
            />
            
            <div class="min-w-0 flex-1">
                <flux:heading size="sm">
                    {{ $header }}
                </flux:heading>
                <flux:text>
                    {{ $subtitle }}
                </flux:text>
            </div>
            <flex:button variant="ghost" size="sm">
                <flux:icon.x />
            </flex:button>
        </div>
    </flux:card>
</div>