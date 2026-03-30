@props(['texto' => '', 'icon' => '', 'color' => '', 'id' => null, 'type' => 'submit'] )


<flux:button
    type="{{ $type }}"          
    icon:trailing="{{ $icon }}" 
    class="!bg-{{$color}} !text-white hover:!bg-{{$color}}/90 transition delay-150 duration-300 ease-in-out  hover:scale-107"
>
    {{ __($texto) }} 
</flux:button>

