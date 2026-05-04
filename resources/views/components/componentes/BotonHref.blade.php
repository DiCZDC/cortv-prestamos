@props(['ruta' => null, 'texto' => '', 'icon' => '', 'id' => null])

@php
    $routeUrl = $id ? route($ruta, $id) : route($ruta);
@endphp

<flux:button 
    href="{{ $routeUrl }}"      
    icon:trailing="{{ $icon }}" 
    class="
     bg-azul-hover! text-azul_oscuro! font-bold text-sm! border-none!
     hover:bg-azul_oscuro! 
     hover:text-hueso!
     transition all delay-150 duration-200 ease-out  
     hover:-translate-y-1.5 active:scale-95 cursor-pointer">
    {{ __($texto) }}
</flux:button>


{{-- class=" bg-rojo-si! text-[#c10007]! font-bold text-sm! border-none!
                            hover:bg-[#c10007]! 
                            hover:text-hueso! 
                            transition-all duration-200 ease-out 
                            hover:-translate-y-1.5 active:scale-95 cursor-pointer" --}}