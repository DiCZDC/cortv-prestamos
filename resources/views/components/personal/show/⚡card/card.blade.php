
<div>
    {{-- Life is available only in the present moment. - Thich Nhat Hanh --}}
    <div class="bg-white rounded-2xl shadow-lg flex flex-col justify-start items-start px-9 py-6 w-[70%] gap-5">
                
        <header class="flex justify-between items-center w-full">
            <div class="inline-flex items-center gap-3">
                <flux:icon name="book-marked" class="size-9 text-black dark:text-hueso" />
                <h1 class="text-xl font-bold text-center">Prestamo en curso</h1>
            </div>

            <div>
                <flux:badge color="green">11 dias restantes</flux:badge
            </div>

        </header>  
        
        <div class="flex flex-col px-2 gap-2.5 w-full">
            @if($this->prestamo_en_curso)
                
                <span class=" inline-flex text-base text-gris_claro font-medium gap-2">
                    <flux:icon.scroll-text />
                    {{$this->prestamo_en_curso->motivo}}
                </span> 


                <p class="text-base text-gris_claro ml-1">
                    <span class="font-semibold">
                        Fecha de entrega:
                    </span>
                    {{$this->prestamo_en_curso->fecha_devolucion }}
                </p>

                <div class="self-center mt-1">
                    <x-componentes.boton-href 
                        ruta="archivo.show" 
                        texto="Ver" 
                        icon="eye" 
                        :id="$this->prestamo_en_curso->id" 
                        />    
                </div>
            @else
                <p class="text-lg mt-4">No tienes prestamos en curso</p>
            @endif
        </div>

    </div>
</div>