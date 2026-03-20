<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid grid-cols-2 gap-4">
    
        @livewire('4cards')
        
        <div class="h-full relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>

    <div class="grid auto-rows-min gap-4 md:grid-cols-2 place-items-center content-center">

        <div class="h-full w-[84%] relative rounded-xl shadow-xl">
        <!-- Titulo de la tabla -->
                <div class="flex flex-row justify-start items-center gap-3 px-8 pt-10">
                    <flux:icon name="package" class="w-10 h-10 text-black" />
                    <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem]"> Proximos Prestamos</span>
                </div>
                                
                <div class="pt-3 px-10 pb-6" >
                    @livewire('proximos_prestamos.tabla')
                </div>
        </div>

        
    </div>

    <div class="h-full w-[84%] relative shadow-xl rounded-xl ">
            <div class="flex flex-row justify-start items-center gap-3 px-8 pt-10">
                <flux:icon name="clock-alert" class="w-[36px]! h-[36px]! text-black" />
                <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem]"> Prestamos Atrasados</span>
            </div>
                                
            <div class="pt-3 px-10 pb-6" >
                    @livewire('prestamos_atrasados.tabla')
            </div>
    </div>      

    
</div>