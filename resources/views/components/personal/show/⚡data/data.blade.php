<main class="w-full h-full flex flex-col gap-10">

    <header class="w-full flex flex-col items-center justify-center gap-6 
                lg:flex-row lg:justify-between">  
        
        {{-- herocard de prestamo en curso --}}
        <article class="w-full flex justify-center items-center lg:w-full ">   
            <livewire:personal.show.carousel :id="$id"/>
        </article>



        <aside class="w-full flex justify-evenly gap-3">
            <livewire:componentes.card 
                titulo='{{ $this->porcentaje_cumplimiento }}' 
                descripcion='Tasa de cumplimiento'
                icono='box' 
                color_text='text-hueso' 
                color_bg='bg-verde_mid dark:bg-verde-confirmacion/20!'
                />
            <livewire:componentes.card 
                titulo='Faltan' 
                descripcion='{{ $this->devoluciones_atrasadas }} devoluciones' 
                icono='triangle-alert' 
                color_bg='bg-amarillo_logo dark:bg-[#bb4d00]/50! dark:text-[#fff1bf]!'
                />
        </aside>

    </header>

    <section class="grid auto-rows-min gap-4 grid-cols-1 place-items-center content-center lg:grid-cols-2">
        <div class="w-full relative rounded-xl shadow-xl 
                lg:w-[84%]
        ">
        <!-- Titulo de la tabla -->
            <livewire:dashboard.index.prestamos.table :id_user='$id' lazy/>
        </div>

        <div class="w-full relative shadow-xl rounded-xl 
                lg:w-[84%]
        ">
            <livewire:dashboard.index.devoluciones.table :id_user='$id' lazy/>
        </div>
        
    </section>
</main>