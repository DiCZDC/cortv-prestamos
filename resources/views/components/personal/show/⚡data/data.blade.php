{{-- @section('styles')
    @vite(['resources/css/app.css', 'resources/css/carrusel.css', 'resources/js/carrusel.js', 'resources/js/app.js'])
@endsection --}}
<main>
    <header class="w-full flex items-center justify-center gap-6  ">  
        
        {{-- herocard de prestamo en curso --}}
        <article class="w-1/2 flex p-5 justify-center">   
            <livewire:personal.show.carousel/>
            {{-- <livewire:personal.show.card 
                :prestamo_en_curso="$this->prestamo_en_curso" 
                /> --}}
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