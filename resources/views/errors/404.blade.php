<x-layouts::app :title="__('403 - Prohibido')">
    <div class="flex h-full w-full flex-1 flex-col items-center justify-center gap-4 rounded-xl">
        <div class="w-100">
            <x-app-logo/>
        </div>
        <h1 class="text-6xl font-bold">
            ERROR 404
        </h1>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7WJ4FnCwJRkO5QwGR1y5879riyH8f7ccG6oQqc9IIbYDBOWGtgNWCpIgZ0nkdZoqTHSR9CcLJZiCKlrbfdslfkOwi84pU&s&ec=121584914" alt="Error403">
        <p class="text-lg text-neutral-600 dark:text-neutral-400">
            {{ __('Esta página no existe.') }}
        </p>
        <flux:button href="{{ route('dashboard') }}" wire:navigate>
                Volver al inicio
        </flux:button>
    </div>
</x-layouts::app>