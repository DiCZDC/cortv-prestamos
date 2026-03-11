<?php

use Livewire\Component;

new class extends Component
{
    public $titulo;
    public $icono; 
    public $descripcion;
    public $bg;


    public function mount($titulo = null, $icono = null, $descripcion=null, $bg=null)
    {
        $this->titulo = $titulo;
        $this->icono = $icono;
        $this->descripcion = $descripcion;
        $this->bg = $bg;
    }
};
?>

<div class="w-[254px] h-[180px] bg-[#AE2B2F] rounded-3xl shadow-lg flex flex-col items-center justify-center gap-2 p-5">
    <flux:icon name="{{ $icono }}" class="w-10 h-10" />
    <span class="text-hueso font-semibold text-[22px] text-center tracking-[-0.38px] leading-none"> {{ $titulo }} </span>                      
    <span class="text-hueso font-semibold text-base text-center"> {{ $descripcion }} </span>
</div>