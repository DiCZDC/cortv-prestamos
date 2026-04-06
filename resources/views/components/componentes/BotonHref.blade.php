@props(['ruta' => null, 'texto' => '', 'icon' => '', 'color' => '', 'id' => null])

@php
    $routeUrl = $id ? route($ruta, $id) : route($ruta);
@endphp

<flux:button 
    href="{{ $routeUrl }}"      
    icon:trailing="{{ $icon }}" 
    class="!bg-{{ $color }} !text-white hover:!bg-{{ $color }}/90 transition delay-150 duration-300 ease-in-out  hover:scale-107"
>
    {{ __($texto) }}
</flux:button>