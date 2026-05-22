@props(['icono' => null, 'texto' => null])

<div class="flex items-center gap-3 text-rojo_claro">
    <flux:icon :name="$icono" class="inline 
            size-9
            md:size-13
    " />
    <h1 class="font-bold inline
                text-3xl
                md:text-4xl
                lg:text-5xl 
    ">{!! $texto !!}</h1>
</div>

