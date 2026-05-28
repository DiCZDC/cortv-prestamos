@props(['ruta' => null, 'texto' => '', 'icon' => '', 'id' => null])

@php
    $routeUrl = $id ? route($ruta, $id) : route($ruta);
@endphp

<flux:button 
    href="{{ $routeUrl }}"      
    icon:trailing="{{ $icon }}" 
    class="
     bg-azul-hover! text-azul_oscuro! font-bold text-sm! border-none!
     hover:bg-azul_oscuro! hover:text-hueso!
     dark:bg-azul_oscuro/60! dark:text-azul-hover!
     dark:hover:bg-azul_oscuro/80! dark:hover:text-hueso!
     transition all delay-100 duration-200 ease-out  
     hover:-translate-y-1.5 active:scale-92 cursor-pointer">
    {{ __($texto) }}
</flux:button>

