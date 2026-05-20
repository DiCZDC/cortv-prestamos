    <div class="flex h-full w-full flex-1 flex-col gap-7 rounded-xl">
        <div class="grid place-items-center 
                    gap-4
                    grid-cols-1
                    lg:grid-cols-2 md:rows-1
                    ">
            <livewire:dashboard.index.4cards />
            <div class="rounded-xl flex self-center items-center justify-center w-3/4 ">
                <livewire:grafica.dashboard />
            </div>
        </div>

        <div class="grid auto-rows-min gap-4 grid-cols-1 place-items-center content-center
                    lg:grid-cols-2
        ">

            <div class="w-[84%] relative rounded-xl shadow-xl">                
                <livewire:dashboard.index.prestamos.table lazy/>
            </div>

            <div class="w-[84%] relative shadow-xl rounded-xl ">
                <livewire:dashboard.index.devoluciones.table lazy/>
            </div>
            
        </div>
        
        
    </div>