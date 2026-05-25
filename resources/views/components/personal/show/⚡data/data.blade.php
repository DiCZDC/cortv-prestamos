
<main>
    <header class="w-full flex items-center justify-center gap-6  ">  
        
        {{-- herocard de prestamo en curso --}}
        <article class="w-1/2 flex p-5 justify-center">   
           
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


        </article>



        <aside class="w-1/2 flex justify-evenly">
            <livewire:componentes.card 
                titulo='{{ $this->porcentaje_cumplimiento }}' 
                descripcion='Tasa de cumplimiento'
                icono='box' 
                color_text='text-hueso' 
                color_bg='bg-verde_mid'
                />
            <livewire:componentes.card 
                titulo='Faltan' 
                descripcion='{{ $this->devoluciones_atrasadas }} devoluciones' 
                icono='triangle-alert' 
                color_bg='bg-amarillo_logo'
                />
        </aside>

    </header>

    <section class="grid auto-rows-min gap-4 grid-cols-1 place-items-center content-center lg:grid-cols-2">
        <div class="w-[84%] relative rounded-xl shadow-xl ">
        <!-- Titulo de la tabla -->
            <livewire:dashboard.index.prestamos.table :id_user='$id' lazy/>
        </div>

        <div class="w-[84%] relative shadow-xl rounded-xl ">
            <livewire:dashboard.index.devoluciones.table :id_user='$id' lazy/>
        </div>
        
    </section>
</main>