<?php

use App\Models\Categoria;
use App\Models\Equipo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    #[Validate('required', message: 'La marca es requerida')]
    #[Validate('min:6', message: 'El nombre de la marca es muy corto')]
    #[Validate('max:50', message: 'El nombre de la marca es muy largo')]
    public $marca;

    #[Validate('required', message: 'El modelo es requerido')]
    #[Validate('min:3', message: 'El nombre del modelo es muy corto')]
    #[Validate('max:50', message: 'El nombre del modelo es muy largo')]
    public $modelo;

    #[Validate('required', message: 'La categoría es requerida')]
    public $categoria;

    #[Computed]
    public function categorias()
    {
        return Categoria::all();
    }

    public function save()
    {
        $this->validate();

        $equipo = Equipo::create([
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'id_categoria' => $this->categoria,
        ]);

        Flux::toast(
            heading: 'Equipo creado',
            text: 'El equipo ha sido creado exitosamente.',
            variant: 'success',
        );
        $this->reset(['marca', 'modelo', 'categoria']);
    }

    public function cancel()
    {
        $this->reset(['marca', 'modelo', 'categoria']);
    }
};
