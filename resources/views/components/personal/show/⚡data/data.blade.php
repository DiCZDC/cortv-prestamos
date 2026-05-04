
<div>
    <div class="grid auto-rows-min gap-4 grid-cols-1 place-items-center content-center
                            lg:grid-cols-2
                    ">
                <div class="h-full w-[84%] relative rounded-xl shadow-xl flex-col ">
                        <div class="flex flex-row items-center gap-3 px-8 pt-10 justify-center">
                            <flux:icon name="package" class="w-10 h-10 text-black dark:text-hueso" />
                            <h1 class="text-2xl font-bold text-center">Prestamo en curso</h1>
                        </div>
                        @if($this->prestamo_en_curso)
                            <h2 class="text-lg  text-center mt-4">
                                <span class="font-semibold">
                                    Motivo:
                                </span>
                                {{$this->prestamo_en_curso->motivo}}</h2>
                            <h2 class="text-lg text-center mt-4">
                                <span class="font-semibold">
                                    Fecha de devolución:
                                </span>
                                {{$this->prestamo_en_curso->fecha_devolucion }}
                                <div class="align-middle w-max mt-6 mx-auto pb-6">
                                    <x-componentes.boton-href 
                                        ruta="archivo.show" 
                                        texto="Ver" 
                                        icon="eye" 
                                        :id="$this->prestamo_en_curso->id" 
                                        color="azul_saturado" 
                                        />    
                                </div>
                        @else
                            <h2 class="text-lg  text-center mt-4">No tienes prestamos en curso</h2>
                        @endif
                </div>
                <div class="w-[84%] flex  justify-around">
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
                </div>

            </div>
            <div class="grid auto-rows-min gap-4 grid-cols-1 place-items-center content-center
                    lg:grid-cols-2
            ">
                <div class="w-[84%] relative rounded-xl shadow-xl">
                <!-- Titulo de la tabla -->
                        <livewire:dashboard.index.prestamos.table :id_user='$id' lazy/>
                </div>

                <div class="w-[84%] relative shadow-xl rounded-xl ">
                    <livewire:dashboard.index.devoluciones.table :id_user='$id' lazy/>
                </div>
                
        </div>
    </div>
</div>