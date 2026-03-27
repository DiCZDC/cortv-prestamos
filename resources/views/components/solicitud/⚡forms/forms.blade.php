<div class="flex px-15 py-8">
    
        <section class="w-1/2 flex flex-col items-start justify-center">
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
            <div class="flex flex-col bg-white shadow-2xl rounded-2xl px-12 py-9 w-140 mt-9">  
                {{-- titulo --}}
                <div class="flex justify-center items-center gap-5 text-rojo_claro">
                    <flux:icon name="command" class="inline size-12" />
                    <h1 class="text-4xl font-bold inline text-center text-wrap">Agrega equipo <br> a la solicitud</h1>
                </div>
                
                {{-- campos --}}
                <div class="gap-7 flex flex-col mt-6">
                    <x-componentes.input-form badge="Requerido" label="Motivo" placeholder="Ingrese el motivo del préstamo" model="motivo" icon="library-big" />
                    
                    <x-componentes.input-form type="date" badge="Requerido" label="Fecha de Devolución" placeholder="Seleccione la fecha de devolución" model="fecha_devolucion" />
                </div>
                
            </div>
            
        </section>

        <section class="w-1/2">
            
            {{-- tabla --}}
            <div>

            </div>

            {{-- botones de envio --}}
            <div>
                
                <div class="text-gris_claro inline-flex gap-4 mt-6">
                    <flux:icon.circle-alert/>
                    <span class="font-bold">Envia tu solicitud</span>
                </div>
                
                <div>

                </div>
            </div>

        </section>
    {{-- </form> --}}
</div>