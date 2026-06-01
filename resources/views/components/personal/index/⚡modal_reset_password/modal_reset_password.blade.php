<div>
    {{-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi --}}
    <flux:modal name="reset-password.{{ $persona->id }}" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Restablecer Contraseña</flux:heading>
                <flux:text class="mt-2">Recomendamos que estes con {{$persona->name }} al momento de restablecer su contraseña, </flux:text>
            </div>
            <div class="w-full flex justify-between">
                <flux:button
                    wire:click="reset_password"
                    class="

                    bg-verde-hover! text-verde-confirmacion! 
                    hover:bg-verde-confirmacion! hover:text-verde-hover! 
                    dark:bg-verde-confirmacion/20! dark:text-verde-hover! 
                    dark:hover:bg-verde-confirmacion/50! dark:hover:text-verde-hover!
                    transition-all duration-200 ease-out delay-100 hover:-translate-y-1.5 
                    active:scale-95 cursor-pointer
                    font-bold 
                    text-sm! 
                    border-none!
                     "
                    icon:trailing="refresh-ccw"
                    >
                    Restablecer
                </flux:button>
                <flux:modal.close name="reset-password.{{ $persona->id }}"z>
                    <flux:button
                        
                        class="
                        bg-rojo-si! text-rojo-negacion! 
                        hover:bg-rojo-negacion! hover:text-hueso! 
                        dark:bg-red-400/20! dark:text-red-200!
                        dark:hover:bg-red-400/50! dark:hover:text-red-200!
                        font-bold text-sm! border-none! 
                        transition-all duration-200 ease-out delay-100 hover:-translate-y-1.5 active:scale-95 cursor-pointer"
                        icon:trailing="circle-x"
                        >
                        Cancelar
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>