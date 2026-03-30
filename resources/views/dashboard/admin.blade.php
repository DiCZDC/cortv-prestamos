<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid 
                gap-4
                grid-cols-1
                lg:grid-cols-2 md:rows-1
                ">
    
        @livewire('4cards')
        
        <div class="h-full relative rounded-xl">
            <livewire:grafica.dashboard />
        </div>
    </div>

    <div class="grid auto-rows-min gap-4 grid-cols-1 place-items-center content-center
                lg:grid-cols-2
    ">

        <div class="h-full w-[84%] relative rounded-xl shadow-xl">
        <!-- Titulo de la tabla -->
                <div class="flex flex-row justify-start items-center gap-3 px-8 pt-10">
                    <flux:icon name="package" class="w-10 h-10 text-black dark:text-hueso" />
                    <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem] dark:text-hueso"> Proximos Prestamos</span>
                </div>
                                
                <div class="pt-3 px-10 pb-6" >
                    @livewire('proximos_prestamos.tabla')
                </div>
        </div>

        <div class="h-full w-[84%] relative shadow-xl rounded-xl ">
            <div class="flex flex-row justify-start items-center gap-3 px-8 pt-10">
                <flux:icon name="clock-alert" class="w-9! h-9! text-black dark:text-hueso" />
                <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem] dark:text-hueso"> Prestamos Atrasados</span>
            </div>
                                
            <div class="pt-3 px-10 pb-6" >
                    @livewire('prestamos_atrasados.tabla')
            </div>
        </div>
        
    </div>

        
    
</div>