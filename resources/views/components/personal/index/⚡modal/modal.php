<?php

use Livewire\Component;
use App\Models\User;
new class extends Component
{
    public $persona;
    public $role ='';


    public function actualizar(){
        User::find($this->persona->id)->syncRoles([$this->role]);
        $this->dispatch('ActualizarPadre');
    }
};