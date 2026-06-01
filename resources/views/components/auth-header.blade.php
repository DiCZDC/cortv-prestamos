@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <flux:heading size="xl" class="text-2xl font-bold text-zinc-900 dark:text-white">
        {{ $title }}
    </flux:heading>
    <flux:subheading class="text-lg text-zinc-600 dark:text-zinc-300

    ">
        {{ $description }}
    </flux:subheading>
</div>
