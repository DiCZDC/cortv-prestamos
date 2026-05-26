
<div class="bg-white rounded-2xl w-full h-full ">
    {{-- Life is available only in the present moment. - Thich Nhat Hanh --}}
    <div class="flex flex-col justify-start items-start px-9 pt-6 pb-12 w-full gap-5">
                
        <header class="flex justify-between items-center w-full">
            <div class="inline-flex items-center gap-3">
                <flux:icon name="book-marked" class="size-9 text-black dark:text-hueso" />
                <h1 class="text-xl font-bold text-center">{{$this->titulo}}</h1>
            </div>

            <div>
                <flux:badge color="green">{{$this->pill}}</flux:badge>
            </div>

        </header>  
        
        <div class="flex flex-col px-2 gap-2.5 w-full">
            {{-- @if($this->prestamo_en_curso) --}}
                
                <span title="{{$this->subtitulo}}" class=" inline-flex text-base text-gris_claro font-medium gap-2 ">
                    <flux:icon.scroll-text />
                    {{Str::limit($this->subtitulo, 40)}}
                </span> 


                <p class="text-base text-gris_claro ml-1 flex gap-2">
                    <flux:icon.calendar />
                    <span class="font-semibold">
                        Fecha de entrega:
                    </span>
                    {{$this->date }}
                </p>

                <div class="self-center mt-1">
                    <x-componentes.boton-href 
                        ruta="archivo.show" 
                        texto="Ver" 
                        icon="eye" 
                        :id="$this->route"
                        />    
                </div>
        </div>

    </div>
</div>