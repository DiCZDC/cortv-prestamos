
<div>
    {{-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi --}}
    <flux:modal name="update-role.{{ $persona->id }}" class="md:w-96">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Actualizar Rol</flux:heading>
                            <flux:text class="mt-2">Cambia el rol de {{$persona->name }}?</flux:text>
                        </div>
                        <flux:select 
                            wire:model.live="role" 
                            label="Selecciona un rol"
                            class="w-full">
                            <flux:select.option value="" disabled selected>Selecciona un rol</flux:select.option>
                            <flux:select.option value="admin">Admin</flux:select.option>
                            <flux:select.option value="trabajador">Trabajador</flux:select.option>
                        </flux:select>
                        <div class="w-full flex justify-between">
                            <flux:modal.close>
                                <x-btn-wire 
                                :disabled="$role==''"
                                wire="actualizar" texto="Actualizar Rol" color="verde_mid" icon="book-lock"  />
                            </flux:modal.close>
                            <flux:modal.close>
                                <x-btn-wire  texto="Cancelar" color="rojo_claro" icon="book-x" />
                            </flux:modal.close>
                        </div>
                    </div>
                </flux:modal>
</div>