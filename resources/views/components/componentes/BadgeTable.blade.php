@props([
    'dias'   => null,
    'colores' => [
        'urgente' => '!bg-azul_saturado',
        'proximo' => '!bg-azul_intenso',
        'normal'  => '!bg-azul_oscuro',
    ],
])

@php
    $color = match(true) {
        $dias !== null && $dias <= 5 => $colores['urgente'],
        $dias !== null && $dias <= 7 => $colores['proximo'],
        $dias !== null && $dias > 7  => $colores['normal'],
        default                      => '',
    };
@endphp

<flux:badge
    {{ $attributes->class([
        $color                      => true,
        '!text-hueso font-semibold' => true,
    ])->merge([
        'size'  => 'lg',
        'inset' => 'top bottom',
    ]) }}
>
    {{ $slot }}
</flux:badge>