@props(['ruta' => null, 'texto' => '', 'icon' => ''])

<flux:button 
    href="{{ route($ruta) }}" 
    target="_blank" 
    rel="noopener noreferrer" 
    icon:trailing="{{ $icon }}" 
    class="bg-rojo_claro! text-white! hover:bg-rojo_claro/90! transition delay-150 duration-300 ease-in-out hover:-translate-y-1"
>
    {{ __($texto) }}
</flux:button>