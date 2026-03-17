<?php

use Livewire\Component;

new class extends Component
{
    public string $titulo;
    public string $icono;
    public string $colorBg = 'bg-white';
    public string $colorText = 'text-black';
    // PROPS PARA EL MODAL
    public string $name;
    public string $tituloModal;
    
    public string $name_table;
    public $datos = [];

    public function mount($datos = [])
    {
        $this->datos = $datos;
    }
};
?>

<div>
    {{-- Trigger: al click carga datos y abre el modal --}}
    <flux:modal.trigger :name="$name">
        <div>
            <livewire:card
                :nombre_modal="$name"
                :titulo="$titulo"
                :descripcion="$datos->first()?->name"
                :icono="$icono"
                :color_bg="$colorBg"
                :color_text="$colorText"
            />
        </div>
    </flux:modal.trigger>

    {{-- Modal --}}
    <flux:modal :name="$name" class="w-[500px] p-6 rounded-2xl">
        <div class="flex flex-col gap-4">
            <span class="font-semibold text-lg">{{ $tituloModal }}</span>

            {{-- @livewire( $name_table , ['datos' => $datos]) --}}
           
        </div>

        <div class="mt-6 flex justify-end">
            <flux:button
                variant="primary"
                x-on:click="$flux.modal('{{ $name }}').close()">
                Cerrar
            </flux:button>
        </div>
    </flux:modal>
</div>