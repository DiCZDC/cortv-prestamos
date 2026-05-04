<?php

use Livewire\Component;
use App\Models\User;
// use Flux
new class extends Component
{
    public $persona;
    public $role ='';


    public function actualizar(){
        User::find($this->persona->id)->syncRoles([$this->role]);
        $this->dispatch('ActualizarPadre');
        Flux::toast(
            heading: 'Rol Actualizado',
            text: 'El rol de ' . $this->persona->name . ' ha sido actualizado exitosamente.',
            variant: 'success',
        );
    }
};