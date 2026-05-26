<?php

use Livewire\Component;
use App\Models\User;
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
        // Flux::toast(heading: 'Funcion ejecutada', text: 'La contraseña ha sido restablecida exitosamente.', variant: 'success');
        try{
            $newPassword = Str::random(12);
            // $user = User::findOrFail($this->persona->user_id);
            // $user->password = $newPassword;
            // $user->save();
            $this->persona ->update([
                'password' => Hash::make($newPassword)
            ]);
            
            Flux::toast(heading: 'Contraseña restablecida', text: 'La contraseña ha sido restablecida exitosamente a: ' . $newPassword, variant: 'success');
        }catch (\Exception $e) {
            Flux::toast(heading: 'Error', text: $e->getMessage(), variant: 'danger');
        }
    }
};
