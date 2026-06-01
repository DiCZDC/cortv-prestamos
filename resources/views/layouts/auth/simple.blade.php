<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="relative min-h-screen m-0 p-0 bg-white dark:bg-linear-to-b dark:from-neutral-950 dark:via-neutral-950/95 dark:to-neutral-900"
        style="background-image: url('{{ asset('img/fondo2.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

        <div class="pointer-events-none absolute inset-0 bg-white/5 dark:bg-neutral-950/70"></div>

        <div class="bg-background relative flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-[420px] flex-col">
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>

            

        @fluxScripts
    </body>
</html>
