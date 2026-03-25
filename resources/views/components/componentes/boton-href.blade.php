@props(['ruta' => null, 'texto' => '', 'icon' => '', 'color' => '', 'id' => null])

@php
    $routeUrl = $id ? route($ruta, $id) : route($ruta);
@endphp

<flux:button 
    href="{{ $routeUrl }}" 
    target="_blank" 
    rel="noopener noreferrer" 
    icon:trailing="{{ $icon }}" 
    class="!bg-{{ $color }} !text-white hover:!bg-{{ $color }}/90 transition delay-150 duration-300 ease-in-out hover:-translate-y-1"
>
    {{ __($texto) }}
</flux:button>