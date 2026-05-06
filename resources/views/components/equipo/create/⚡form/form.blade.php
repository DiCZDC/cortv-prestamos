<form wire:submit="save">
    <section class="w-full flex flex-col items-start justify-center gap-4 py-1 
            ">
        <div class="flex flex-col px-2 py-4 w-full
                    dark:bg-neutral-800
        ">  

            <div class="flex justify-center items-center gap-3 mb-1 text-rojo_claro">
                <flux:icon name="file" class="inline 
                size-8
                md:size-12" />
                <h1 class="font-bold inline
                        text-2xl 
                        md:text-4xl
                ">Datos de la solicitud</h1>
            </div>


            <div class="gap-5 flex flex-col mt-7">
                <flux:field>
                    <x-componentes.input-form badge="Requerido" label="Marca" placeholder="Ingrese la marca del equipo" model="marca" icon="tag" />
                    <x-componentes.input-form badge="Requerido" label="Modelo" placeholder="Ingrese el modelo del equipo" model="modelo" icon="cog" />
                </flux:field>
                <flux:select wire:model.live="categoria" badge="Requerido" label="Categoría del equipo" placeholder="Seleccione la categoría del equipo">
                    <flux:select.option value="">Seleccione una categoría</flux:select.option>
                
                    @forelse ($this->categorias as $categoria)
                        <flux:select.option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</flux:select.option>
                    @empty
                        <flux:select.option disabled>No hay categorías disponibles</flux:select.option>
                    @endforelse
                    
                </flux:select>  
                
            </div>
            
            <div class="flex gap-15 row-reverse justify-center mt-12">
                <x-componentes.btnsformulario type="submit" texto="Crear" tipo="aceptar" icon="circle-check" />
                <x-componentes.btnsformulario type="button" texto="Cancelar" tipo="cancelar" icon="circle-x" wire:click="cancel" />  
            </div>
        </div>
        
    </section>


</form>
   