@props(['texto' => '', 'icon' => '', 'color' => '', 'id' => null, 'type' => 'submit', 'trailing' => false, 'disabled' => false, 'tipo' => 'normal'])

@php
    $baseClasses = '';
    if ($tipo === 'aceptar') {
        $baseClasses = "bg-verde-hover! text-verde-confirmacion! font-bold text-sm! border-none! hover:bg-verde-confirmacion! hover:text-verde-hover! transition-all duration-200 ease-out delay-100 hover:-translate-y-1.5 active:scale-95 cursor-pointer";
    } elseif ($tipo === 'cancelar') {
        $baseClasses = "bg-rojo-si! text-rojo-negacion! font-bold text-sm! border-none! hover:bg-rojo-negacion! hover:text-hueso! transition-all duration-200 ease-out delay-100 hover:-translate-y-1.5 active:scale-95 cursor-pointer";
    } else {
        $baseClasses = "!bg-{$color} border-none !text-white hover:!bg-{$color}/90 transition delay-150 duration-300 ease-in-out hover:scale-107 cursor-pointer";
    }
@endphp

@if($trailing)
    <flux:button 
        {{ $attributes }}
        type="{{ $type }}"
        icon:trailing="{{ $icon }}" 
        :disabled="$disabled"
        class="{{ $baseClasses }}"
    >
        {{ __($texto) }} 
    </flux:button>
@else
    <flux:button 
        {{ $attributes }}
        type="{{ $type }}"
        icon="{{ $icon }}"
        :disabled="$disabled"
        class="{{ $baseClasses }}"
    >
        {{ __($texto) }} 
    </flux:button>
@endif  

