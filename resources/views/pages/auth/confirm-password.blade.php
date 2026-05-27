<x-layouts::auth :title="__('Confirm password')">
    <div class="flex flex-col gap-6 rounded-lg border border-white/40 bg-white/75 p-6 text-zinc-700 shadow-xl shadow-black/10 backdrop-blur-md dark:border-white/10 dark:bg-zinc-950/80 dark:text-zinc-100 dark:shadow-black/40">
        
        <div>
            <x-app-logo/>
        </div>

        <x-auth-header
            :title="__('Confirma tu contraseña')"
            :description="__('Por favor, confirma tu contraseña para habilitar la autenticación de dos factores.')"
        />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input
                name="password"
                :label="__('Contraseña')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Contraseña')"
                viewable
            />

            <flux:button    variant="primary" type="submit" icon:trailing="rotate-ccw-key"
                            class="w-full 
                            bg-rojo-si! text-rojo-negacion! font-extrabold border-none!
                            hover:bg-rojo-negacion! 
                            hover:text-hueso! 
                            transition-all duration-200 ease-out delay-150
                            hover:-translate-y-1.5 active:scale-95 cursor-pointer"  
                            data-test="confirm-password-button">
                {{ __('Confirmar') }}
            </flux:button>
        </form>
    </div>
</x-layouts::auth>
