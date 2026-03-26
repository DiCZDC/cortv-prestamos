@props(['icono' => null, 'texto' => null])

<div class="flex items-center gap-3 text-gris_claro pl-1.5">
    @if($icono)
        <flux:icon :name="$icono" class="inline size-9" />
    @endif
    <span class="text-2xl text-gris_claro font-semibold " >
        {{$texto}}
    </span>
</div>
