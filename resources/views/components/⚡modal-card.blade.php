<?php

use Livewire\Component;

new class extends Component
{
    public string $titulo;
    public string $icono;
    public string $color_bg = 'bg-white';
    public string $color_text = 'text-black';
    public string $iconoT = "info";
    // PROPS PARA EL MODAL
    public string $name;
    public string $tituloModal;
    // public string $table;
    public string $table;
    
    public $datos = [];
    public $descripcion;

    public function mount($datos = [])
    {
        $this->datos = $datos;
    }
};
?>

<div >
    {{-- Trigger: al click carga datos y abre el modal --}}
    <flux:modal.trigger :name="$name">
        <div class="cursor-pointer rounded-2xl">
            <livewire:card
                :nombre_modal="$name"
                :titulo="$titulo"
                :descripcion="$descripcion"
                :icono="$icono"
                :color_bg="$color_bg"
                :color_text="$color_text"

            />
        </div>
    </flux:modal.trigger>

    {{-- Modal --}}
    <flux:modal :name="$name" class="w-[80%] p-6 rounded-2xl
        md:w-auto
    ">
        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-4">
                <flux:icon name="{{ $iconoT }}" class="w-7 h-7 text-black" />
                <span class="font-semibold text-lg">{{ $tituloModal }}</span>
            </div>

            <livewire:dynamic-component :component="$table" :datos="$datos" />
           
        </div>

    </flux:modal>
</div>