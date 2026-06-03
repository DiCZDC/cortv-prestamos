@props([
    'icono' => 'bolt', 
    'titulo' => '',
    'descripcion' => '',
])

<div class="bg-white border border-zinc-400 flex flex-col items-start justify-center p-8 gap-3 rounded-xl font-jakarta
            transition duration-300 ease-in-out
            hover:-translate-y-1.5 hover:shadow-lg hover:border-rojo-negacion
            dark:bg-zinc-800!
            ">


    <div class="flex items-center bg-rojo-si dark:bg-rojo-negacion  p-3 rounded-xl">
        <flux:icon name="{{ $icono }}" class="text-rojo-negacion dark:text-rojo-si" />
    </div>

    <div>
        <h3 class="text-xl font-semibold text-zinc-800 dark:text-hueso select-none">{{ ($titulo) }}</h3>
    </div>

    <div>
        <p class="text-gray-500 dark:text-zinc-200 md:text-base text-xs select-none">{{ ($descripcion) }}</p>
    </div>
</div>