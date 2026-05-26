<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

new class extends Component
{
    public $persona;

    public function reset_password()
    {
        $newPassword = Str::random(12);
        $this->persona->password = Hash::make($newPassword);
        $this->persona->save();
    }
};
