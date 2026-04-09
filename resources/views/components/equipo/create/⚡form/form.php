<?php

use Livewire\Component;
use App\Models\Categoria;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
new class extends Component
{
    #[Validate('required',message:'La marca es requerida')]
    #[Validate('min:6',message:'El nombre de la marca es muy corto')]
    #[Validate('max:50',message:'El nombre de la marca es muy largo')]
    public $marca;
    #[Validate('required',message:'El modelo es requerido')]
    #[Validate('min:3',message:'El nombre del modelo es muy corto')]
    #[Validate('max:50',message:'El nombre del modelo es muy largo')]
    public $modelo;
    #[Validate('required',message:'La categoría es requerida')]
    public $categoria;
    
    #[Computed]
    public function categorias(){
        return Categoria::all();
    }
};