
<div>
    {{-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi --}}
    <flux:modal name="reset-password.{{ $persona->id }}" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Restablecer Contraseña</flux:heading>
                <flux:text class="mt-2">¿Estas segur@ de que deseas restablecer la contraseña de {{$persona->name }}?</flux:text>
            </div>
            <div class="w-full flex justify-between">
                <flux:button
                    class="bg-verde-hover! text-verde-confirmacion! font-bold text-sm! border-none! hover:bg-verde-confirmacion! hover:text-verde-hover! transition-all duration-200 ease-out delay-100 hover:-translate-y-1.5 active:scale-95 cursor-pointer"
                    icon:trailing="refresh-ccw"
                    >
                    Restablecer
                </flux:button>
                <flux:button
                    class="bg-rojo-si! text-rojo-negacion! font-bold text-sm! border-none! hover:bg-rojo-negacion! hover:text-hueso! transition-all duration-200 ease-out delay-100 hover:-translate-y-1.5 active:scale-95 cursor-pointer"
                    icon:trailing="circle-x"
                    >
                    Cancelar
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>