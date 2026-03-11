<?php

use Livewire\Component;

new class extends Component
{
    public $titulo;
    public $icono; 
    public $descripcion;
    public $color_text = 'hueso';
    public $color_bg;


    public function mount($titulo = null, $icono = null, $descripcion=null, $color_bg = null)   
    {
        $this->titulo = $titulo;
        $this->icono = $icono;
        $this->descripcion = $descripcion;
        $this->color_bg = $color_bg;        
    }
};
?>

<div class="w-[254px] h-[180px] {{$color_bg}} rounded-3xl shadow-lg flex flex-col items-center justify-center gap-2 p-5">
    <flux:icon name="{{ $icono }}" class="w-10 h-10 text-{{$color_text}}" />
    <span class="text-{{$color_text}} font-semibold text-[22px] text-center tracking-[-0.38px] leading-none"> {{ $titulo }} </span>                      
    <span class="text-{{$color_text}} font-semibold text-base text-center"> {{ $descripcion }} </span>
</div>