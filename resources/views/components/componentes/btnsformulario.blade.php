@props(['texto' => '', 'icon' => '', 'color' => '', 'id' => null, 'type' => 'submit', 'trailing' => false, 'disabled' => false])

@if($trailing)
    @if($disabled)
    <flux:button 
        {{ $attributes }}
        type="{{ $type }}"
        icon:trailing="{{ $icon }}" 
        disabled
        class="!bg-{{$color}} border-none !text-white hover:!bg-{{$color}}/90 transition delay-150 duration-300 ease-in-out hover:scale-107 cursor-pointer"
    >
        {{ __($texto) }} 
    </flux:button>
    @else
        <flux:button 
        {{ $attributes }}
        type="{{ $type }}"
        icon:trailing="{{ $icon }}"         
        class="!bg-{{$color}} border-none !text-white hover:!bg-{{$color}}/90 transition delay-150 duration-300 ease-in-out hover:scale-107 cursor-pointer"
    >
        {{ __($texto) }} 
    </flux:button>
    @endif
@else
    @if($disabled)
    
    <flux:button 
        {{ $attributes }}
        type="{{ $type }}"
        icon="{{ $icon }}"
        disabled 
        class="!bg-{{$color}} border-none !text-white hover:!bg-{{$color}}/90 transition delay-150 duration-300 ease-in-out hover:scale-107 cursor-pointer"
    >
        {{ __($texto) }} 
    </flux:button>
    @else
        <flux:button 
        {{ $attributes }}
        type="{{ $type }}"
        icon="{{ $icon }}"
        class="!bg-{{$color}} border-none !text-white hover:!bg-{{$color}}/90 transition delay-150 duration-300 ease-in-out hover:scale-107 cursor-pointer"
    >
        {{ __($texto) }} 
        </flux:button>
    @endif

@endif  

