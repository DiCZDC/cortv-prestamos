@props([
    'badge' => null,
    'label' => '',
    'placeholder' => '',
    'icon' => null,
    'model' => null,
    'type' => 'text',
    'required' => false,
    'disabled' => false,
    // Valores soportados: live.blur, live, defer, normal.
    'wire' => 'live.blur',
])

@php
    $wire = in_array($wire, ['live.blur', 'live', 'defer', 'normal'], true) ? $wire : 'live.blur';
@endphp

<flux:field>
    @if(filled($badge))
        <flux:label class="text-gris_claro! text-base! font-semibold" badge="{{ $badge }}">{{ $label }}</flux:label>
    @else
        <flux:label>{{ $label }}</flux:label>
    @endif

    @if(filled($model))
        @if($wire === 'live.blur')
            @if(filled($icon))
                <flux:input wire:model.live.blur="{{ $model }}" icon:trailing="{{ $icon }}" placeholder="{{ $placeholder }}" type="{{ $type }}" :required="$required" :disabled="$disabled" />
            @else
                <flux:input wire:model.live.blur="{{ $model }}" placeholder="{{ $placeholder }}" type="{{ $type }}" :required="$required" :disabled="$disabled" />
            @endif
        @elseif($wire === 'live')
            @if(filled($icon))
                <flux:input wire:model.live="{{ $model }}" icon:trailing="{{ $icon }}" placeholder="{{ $placeholder }}" type="{{ $type }}" :required="$required" :disabled="$disabled" />
            @else
                <flux:input wire:model.live="{{ $model }}" placeholder="{{ $placeholder }}" type="{{ $type }}" :required="$required" :disabled="$disabled" />
            @endif
        @elseif($wire === 'defer')
            @if(filled($icon))
                <flux:input wire:model.defer="{{ $model }}" icon:trailing="{{ $icon }}" placeholder="{{ $placeholder }}" type="{{ $type }}" :required="$required" :disabled="$disabled" />
            @else
                <flux:input wire:model.defer="{{ $model }}" placeholder="{{ $placeholder }}" type="{{ $type }}" :required="$required" :disabled="$disabled" />
            @endif
        @else
            @if(filled($icon))
                <flux:input wire:model="{{ $model }}" icon:trailing="{{ $icon }}" placeholder="{{ $placeholder }}" type="{{ $type }}" :required="$required" :disabled="$disabled" />
            @else
                <flux:input wire:model="{{ $model }}" placeholder="{{ $placeholder }}" type="{{ $type }}" :required="$required" :disabled="$disabled" />
            @endif
        @endif
    @else
        @if(filled($icon))
            <flux:input icon:trailing="{{ $icon }}" placeholder="{{ $placeholder }}" type="{{ $type }}" :required="$required" :disabled="$disabled" />
        @else
            <flux:input placeholder="{{ $placeholder }}" type="{{ $type }}" :required="$required" :disabled="$disabled" />
        @endif
    @endif

    @if(filled($model))
        @error($model)
            <span class="text-rojo_claro text-sm">{{ $message }}</span>
        @enderror
    @endif
</flux:field>