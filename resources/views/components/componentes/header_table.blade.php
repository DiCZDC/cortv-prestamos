@props(['icon' => null])

<flux:table.column 
    {{ $attributes->class(['text-gris_claro! text-base! font-semibold' => true]) }}>

    @if($icon)
        <flux:icon :name="$icon" class="text-gris_claro! mr-2"/>
    @endif
    
    {{ $slot }}
</flux:table.column>