<?php

use Livewire\Component;

new class extends Component
{
    public $titulo;
    public $icono; 
    public $descripcion;
    public $color_text;
    public $color_bg;

    public function mount($titulo = null, $icono = null, $descripcion=null, $color_bg = null, $color_text=null)   
    {
        $this->titulo = $titulo;
        $this->icono = $icono;
        $this->descripcion = $descripcion;
        $this->color_bg = $color_bg;
        $this->color_text = $color_text;
    }
};
?>

<div class="w-[254px] h-[180px] {{$color_bg}} rounded-3xl shadow-lg flex flex-col items-center justify-center gap-2 p-5">
    <flux:icon name="{{ $icono }}" class="w-10 h-10 {{$color_text}}" />
    <span class="{{$color_text}} font-semibold text-[22px] text-center tracking-[-0.38px] leading-none"> {{ $titulo }} </span>                      
    <span class="{{$color_text}} font-semibold text-base text-center"> {{ $descripcion }} </span>
</div>