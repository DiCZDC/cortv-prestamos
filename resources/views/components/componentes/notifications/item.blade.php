<?php

use Livewire\Component;

new class extends Component
{
    //
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
                    {{ Auth::User()->name }}
                </flux:heading>
                <flux:text>
                    This is a notification message.
                </flux:text>
            </div>
            <flex:button variant="ghost" size="sm">
                <flux:icon.x />
            </flex:button>
        </div>
    </flux:card>
</div>