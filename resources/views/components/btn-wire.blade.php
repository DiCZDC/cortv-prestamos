@props([
    'texto' => '', 
    'icon' => '', 
    'color' => '',
    'wire' => '',
    'disabled' => false,
])
  
    @if($disabled)
    <flux:button
        disabled
        wire:click="{{ $wire }}"
        icon="{{ $icon }}" 
        class="!bg-{{$color}} border-none !text-white hover:!bg-{{$color}}/90 transition delay-150 duration-300 ease-in-out hover:scale-107 cursor-pointer"
    >
        {{ __($texto) }} 
    </flux:button>
    @else
        <flux:button
        wire:click="{{ $wire }}"
        icon="{{ $icon }}" 
        class="!bg-{{$color}} border-none !text-white hover:!bg-{{$color}}/90 transition delay-150 duration-300 ease-in-out hover:scale-107 cursor-pointer" >
        {{ __($texto) }}
        </flux:button>     
    @endif

