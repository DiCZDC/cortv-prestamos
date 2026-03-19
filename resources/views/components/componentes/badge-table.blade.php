@props(['dias'])

<flux:badge
    {{ $attributes->class([
        '!bg-azul_saturado' => $dias <= 3,
        '!bg-azul_intenso'  => $dias > 3 && $dias <= 8,
        '!bg-azul_oscuro'   => $dias > 8,
        '!text-hueso font-semibold' => true,
    ])->merge([
        'size' => 'lg', 
        'inset' => 'top bottom'
    ]) }}
>
    {{ $slot }}
</flux:badge>