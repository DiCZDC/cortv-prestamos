<form wire:submit="save">

    <div class="flex px-15 py-3">
    
        <section class="w-1/2 flex flex-col items-start justify-center gap-4">
                {{-- div de la primera parte del formulario --}}
            <div class="flex flex-col bg-white shadow-2xl rounded-2xl px-12 py-9 w-140">  
                {{-- titulo --}}
                <div class="flex justify-center items-center gap-3 mb-1 text-rojo_claro">
                    <flux:icon name="file" class="inline size-12" />
                    <h1 class="text-4xl font-bold inline">Datos de la solicitud</h1>
                </div>
                
                {{-- campos --}}
                <div class="gap-7 flex flex-col mt-7">
                    <x-componentes.input-form badge="Requerido" label="Motivo" placeholder="Ingrese el motivo del préstamo" model="motivo" icon="library-big" />
                    <x-componentes.input-form type="date" badge="Requerido" label="Fecha de Devolución" placeholder="Seleccione la fecha de devolución" model="fecha_devolucion" />
                    <x-componentes.input-form type="date" badge="Requerido" label="Fecha de Préstamo" placeholder="Seleccione la fecha de préstamo" model="fecha_prestamo" />
                </div>
                
            </div>
            
            {{-- segunda parte del formulario --}}
            @livewire('solicitud.seleccion_unidad_form')
            
        </section>

        <section class="w-1/2">
            
            {{-- tabla --}}
            <div class="flex flex-col bg-white shadow-2xl rounded-2xl items-center py-6 ">
                {{-- titulo de la tabla y del contenedor --}}
                <div class="flex justify-center items-center gap-5 mb-2 text-rojo_claro">
                    <flux:icon name="scroll-text" class="inline size-12" />
                    <h1 class="text-4xl font-bold inline text-center text-wrap">Equipo solicitado</h1>
                </div>

                <div class="p-15">
                    <flux:table>
                        <flux:table.columns>
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
                                <flux:table.cell class="flex justify-end">
                                    <x-componentes.btnsformulario 
                                        type="button" 
                                        texto="Eliminar" 
                                        color="rojo_claro" 
                                        icon="trash" 
                                        wire:click="eliminar_equipo({{ $equipo->id }})" 
                                    />
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
                </div>

            </div>

            {{-- botones de envio --}}
            <div class="flex flex-col items-center justify-end mt-6 gap-4">
                
                <div class="text-gris_claro text-lg inline-flex gap-4 mt-6">
                    <flux:icon.circle-alert/>
                    <span class="font-extrabold">Envia tu solicitud</span>
                </div>
                
                <div class="flex gap-10 row-reverse">
                    <x-componentes.btnsformulario type="submit" texto="Enviar" color="verde_mid" icon="send" />
                    <x-componentes.btnsformulario type="button" texto="Cancelar" color="rojo_claro" icon="circle-x" />  
                </div>
            </div>

        </section>

    </form>    
</div>