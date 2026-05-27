<form wire:submit="save">

    <div class="flex flex-col py-3 
        gap-6
        lg:gap-0
        lg:flex-row
        ">
    
        <section class="w-full flex flex-col items-start justify-center gap-4 py-7 
                        md:px-1/10
                        lg:px-[6%] lg:w-1/2
                ">
                {{-- div de la primera parte del formulario --}}
            <div class="flex flex-col bg-white shadow-xl rounded-2xl px-12 py-9 w-full
                        dark:bg-neutral-800
            ">  

                <div class="flex justify-center items-center gap-3 mb-1 text-rojo_claro">
                    <flux:icon name="file-box" class="inline 
                    size-8
                    md:size-12" />
                    <h1 class="font-bold inline
                            text-2xl 
                            md:text-4xl
                    ">Datos de la solicitud</h1>
                </div>


                <div class="gap-8 flex flex-col mt-7">
                    <flux:field>
                        <x-componentes.input-form badge="Requerido" label="Motivo" placeholder="Ingrese el motivo del préstamo" model="motivo" icon="library-big" />
                        <flux:description class="!mt-0">El motivo del prestamo debe tener al menos 10 caracteres y 255 como maximo </flux:description>
                    </flux:field>

                    <div class="grid grid-cols-1 xs:grid-cols-2 gap-10  xs:gap-4">
                        <flux:input type="date" wire:model.live="fecha_prestamo" badge="Requerido" label="Fecha de Préstamo" placeholder="Seleccione la fecha de préstamo" min="{{ now()->toDateString() }}" />
                        <flux:input type="date" wire:model.live="fecha_devolucion" badge="Requerido" label="Fecha de Devolución" placeholder="Seleccione la fecha de devolución" min="{{ $fecha_prestamo ?? now()->toDateString() }}" />
                    </div>
                
                </div>
                
            </div>
            
            {{-- segunda parte del formulario --}}
            <livewire:prestamo.create.seleccion_unidad_form
                :from="$fecha_prestamo"
                :to="$fecha_devolucion"
                :key="'seleccion-unidad-'.$fecha_prestamo.'-'.$fecha_devolucion"
            />
            
        </section>

        <section class="w-full py-1 flex flex-col  justify-center gap-4
                        md:px-[10%]
                        lg:px-[4%] lg:w-1/2
                ">
            
            {{-- tabla --}}
            <div class="flex flex-col bg-white shadow-xl rounded-2xl items-center py-6 max-h-160
                        dark:bg-neutral-800
            ">
                {{-- titulo de la tabla y del contenedor --}}
                <div class="flex justify-center items-center gap-5 mb-2 text-rojo_claro">
                    <flux:icon name="scroll-text" class="inline size-8 md:size-12" />
                    <h1 class="font-bold inline text-center text-wrap
                            text-2xl    
                            md:text-4xl
                    ">Equipo solicitado</h1>
                </div>

                <div class="py-3 px-5 w-8/10">
                    <flux:table container:class="max-h-[513px]">
                        <flux:table.columns sticky 
                        class="bg-white 
                                dark:bg-neutral-800
                        ">
                            <x-componentes.header_table icon="hard-drive"> Equipo </x-componentes.header_table>
                            <x-componentes.header_table icon="tags">Sicipo </x-componentes.header_table>
                            <flux:table.column></flux:table.column>                           
                        </flux:table.columns>
                       
                        <flux:table.rows>
                            @forelse ($this->unidades_seleccionadas as $equipo)

                            <flux:table.row :key="$equipo->id">
                                <flux:table.cell>
                                    {{ $equipo->equipo->marca . " " . $equipo->equipo->modelo }}
                                </flux:table.cell>
                                <flux:table.cell>
                                    {{ $equipo->sicipo }}
                                </flux:table.cell>
                                <flux:table.cell>
                                    <flux:icon.circle-x class="transition delay-150 duration-300 ease-in-out  hover:scale-120 cursor-pointer text-rojo_claro" wire:click="eliminar_equipo({{ $equipo->id }})" />
                                </flux:table.cell>
                            </flux:table.row>

                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="3" class="text-center py-4">
                                    No se han agregado equipos a la solicitud.
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                        </flux:table.rows>
                    </flux:table>
                    
                    <flux:error name="equipos_seleccionados" class="mt-2 text-center" />
                </div>

            </div>

            {{-- botones de envio --}}
            <div class="flex flex-col items-center 
            gap-4
            ">
                
             
             @role('trabajador')
                <div class="text-gris_claro text-lg inline-flex gap-4 mt-6">
                        <flux:icon.circle-alert/>
                        <span class="font-extrabold">Envia tu solicitud</span>    
                    @endrole
                </div>

             @role('admin')
                <div class="flex flex-col items-center justify-start gap-4 mt-2">
                    <flux:field>
                        <flux:label badge="Requerido">
                            <span class="text-gris_claro text-base font-semibold">Trabajador</span>
                        </flux:label>

                        <flux:select wire:model.live="trabajador">
                        
                            <flux:select.option value="">Seleccione un trabajador</flux:select.option>
                        
                            @forelse ($this->trabajadores as $trabajador)
                            
                            <flux:select.option value="{{ $trabajador->id }}">{{ $trabajador->name }}</flux:select.option>
                                
                            @empty
                                <flux:select.option disabled>No hay trabajadores disponibles</flux:select.option>
                            @endforelse
                            
                        </flux:select>                             
                        
                        <flux:error name="trabajador" /> 
                        <flux:description class="!mt-0">Debe seleccionarse un trabajador para quien se adjudicara el préstamo.</flux:description>
                    </flux:field>
                </div>
                @endrole
                    
                
                <div class="flex  gap-15 row-reverse justify-center mt-2">
                    <x-componentes.btnsformulario type="submit" texto="Enviar" tipo="aceptar" icon="send" :trailing="true"/>
                    <x-componentes.btnsformulario type="button" texto="Cancelar" tipo="cancelar" icon="circle-x" :trailing="true"/>  
                </div>
            </div>

        </section>

    </form>
   
</div>