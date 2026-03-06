@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="CORTV Prestamos" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            {{-- <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" /> --}}
            <img src="img/logo.png" alt="CORTV logo">
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="CORTV" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            {{-- <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" /> --}}
        </x-slot>
    </flux:brand>
@endif
