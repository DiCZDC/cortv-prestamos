@props([
    'icon' => '',
    'ruta' => '',
    'texto' => '',
])

@php
    $isCurrent = request()->routeIs($ruta);
@endphp

<flux:sidebar.item
    class="h-8.5! border border-transparent transition duration-300 ease-in-out
        hover:bg-rojo-si! hover:translate-x-2.5 hover:text-rojo-texto!
           dark:hover:bg-white/7! dark:hover:!text-white
           data-current:bg-rojo_claro! data-current:!text-white data-current:border-zinc-200!
           hover:data-current:!text-white
           [&_[data-flux-icon]]:!size-5"
    :icon="$icon"
    :href="$isCurrent ? null : route($ruta)"
    :current="$isCurrent"
    :wire:navigate="!$isCurrent"
>
    {{ __($texto) }}
</flux:sidebar.item>