<x-layouts::auth :title="__('Registrate')">
    <div class="flex flex-col gap-6 rounded-lg border border-white/40 bg-white/75 p-10 text-zinc-700 shadow-xl shadow-black/10 backdrop-blur-md dark:border-white/10 dark:bg-zinc-950/80 dark:text-zinc-100 dark:shadow-black/40 w-113.75!">
        
        <div>
            <x-app-logo/>
        </div>
        
        <x-auth-header :title="__('Crea una cuenta')" :description="__('Ingresa tus datos a continuación para crear tu cuenta')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Nombre completo')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Nombre completo')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Dirección de correo electrónico')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Contraseña')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Contraseña')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirmar contraseña')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirmar contraseña')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" icon:trailing="user-round-plus" class="w-full 
                            bg-rojo-si! text-rojo-negacion! font-extrabold border-none!
                            hover:bg-rojo-negacion! 
                            hover:text-hueso! 
                            transition-all duration-200 ease-out delay-150
                            hover:-translate-y-1.5 active:scale-95 cursor-pointer" 
                            data-test="register-user-button">    
                    {{ __('Crear cuenta') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('¿Ya tienes una cuenta?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Inicia sesión') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
