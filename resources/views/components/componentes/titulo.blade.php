@props(['icono' => null, 'texto' => null])

<div class="flex items-center gap-3 text-rojo_claro">
    <flux:icon :name="$icono" class="inline size-13" />
    <h1 class="text-5xl font-bold inline">{{ $texto }}</h1>
</div>

