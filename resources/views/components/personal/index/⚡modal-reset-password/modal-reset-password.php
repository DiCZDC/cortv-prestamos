<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Flux\Flux;

new class extends Component
{
    public $persona;

    public function reset_password()
    {
        try{
            $newPassword = Str::random(12);
            $this->persona->forceFill([
                'password' => Hash::make($newPassword),
                'remember_token' => Str::random(10),
            ])->save();
            Flux::toast(heading: 'Contraseña restablecida', text: 'La contraseña ha sido restablecida exitosamente.', variant: 'success');
        }catch (\Exception $e) {
            throw ValidationException::withMessages(['error' => 'Ocurrió un error al restablecer la contraseña.']);
            Flux::toast(heading: 'Error', text: $e->getMessage(), variant: 'danger');
        }

        return $newPassword;
    }
};
