    <x-layouts::auth :title="__('Iniciar Sesión')">
    <div class="flex flex-col gap-6 rounded-lg border border-white/40 bg-white/75 p-10 text-zinc-700 shadow-xl shadow-black/10 backdrop-blur-md dark:border-white/10 dark:bg-zinc-950/80 dark:text-zinc-100 dark:shadow-black/40">
        
        {{-- <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-9 w-9 mb-1 items-center justify-center rounded-md">
                        <x-app-logo/>
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
        </a> --}}

        <div>
            <x-app-logo/>
        </div>
        
        <x-auth-header :title="__('Inicia Sesión')" :description="__('Ingresa tus credenciales para acceder')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Dirección de correo electrónico')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                {{-- <flux:input
                    class="caret-red-500!"
                    name="password"
                    :label="__('Contraseña')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Contraseña')"
                    viewable
                /> --}}
                <flux:input
                    class="border-red-500!"
                    name="password"
                    :label="__('Contraseña')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Contraseña')"
                    viewable
                />
                
            </div>

            <flux:checkbox 
                class="[--color-accent:var(--color-red-700)] text-zinc-600 dark:text-zinc-200"
                name="remember" 
                :label="__('Recuérdame')" 
                :checked="old('remember')" 
            />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" icon:trailing="log-in" 
                            class="w-full 
                            bg-rojo-si! text-rojo-negacion! font-extrabold border-none!
                            hover:bg-rojo-negacion! hover:text-hueso! 
                            
                            dark:bg-red-400/20! dark:text-red-200! 
                            dark:hover:bg-red-400/50! dark:hover:text-red-200!
                            transition-all duration-200 ease-out delay-150
                            hover:-translate-y-1.5 active:scale-95 cursor-pointer" 
                            data-test="login-button">
                            
                    {{ __('Iniciar sesión') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-200">
                <span>{{ __('¿No tienes una cuenta?') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('Regístrate') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts::auth>
