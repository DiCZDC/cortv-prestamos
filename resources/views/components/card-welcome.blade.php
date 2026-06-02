@props([
    'icono' => 'bolt', 
    'titulo' => '',
    'descripcion' => '',
])

<div class="bg-white border border-zinc-400 flex flex-col items-start justify-center p-8 gap-3 rounded-xl font-jakarta
            transition duration-300 ease-in-out
            hover:-translate-y-1.5 hover:shadow-lg hover:border-rojo-negacion">


    <div class="flex items-center bg-rojo-si p-3 rounded-xl">
        <flux:icon name="{{ $icono }}" class="text-rojo-negacion" />
    </div>

    <div>
        <h3 class="text-xl font-semibold text-zinc-800 dark:text-white">{{ ($titulo) }}</h3>
    </div>

    <div>
        <p class="text-gray-500 dark:text-zinc-100 md:text-base text-xs">{{ ($descripcion) }}</p>
    </div>
</div>