<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid grid-cols-2 gap-4">
           
            @livewire('4cards')
            
            <div class="h-full relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            
        </div>
    
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">

            <div class="h-full relative aspect-video overflow-hidden rounded-xl shadow-xl ">
                <!-- Titulo de la tabla -->
                    <div class="flex flex-row justify-start items-center gap-3 px-8 pt-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <path
                                d="M27.5 15.6666L12.5 7.01665M5.45 11.6L20 20.0166L34.55 11.6M20 36.8V20M35 26.6666V13.3333C34.9994 12.7488 34.8451 12.1747 34.5526 11.6686C34.26 11.1625 33.8396 10.7423 33.3333 10.45L21.6667 3.78331C21.1599 3.49075 20.5851 3.33673 20 3.33673C19.4149 3.33673 18.8401 3.49075 18.3333 3.78331L6.66667 10.45C6.16044 10.7423 5.73997 11.1625 5.44744 11.6686C5.1549 12.1747 5.0006 12.7488 5 13.3333V26.6666C5.0006 27.2512 5.1549 27.8253 5.44744 28.3314C5.73997 28.8375 6.16044 29.2577 6.66667 29.55L18.3333 36.2166C18.8401 36.5092 19.4149 36.6632 20 36.6632C20.5851 36.6632 21.1599 36.5092 21.6667 36.2166L33.3333 29.55C33.8396 29.2577 34.26 28.8375 34.5526 28.3314C34.8451 27.8253 34.9994 27.2512 35 26.6666Z"
                                stroke="#1E1E1E" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="font-semibold text-[24px] text-black [word-spacing:0.3rem]"> Proximos Prestamos</span>
                    </div>
                                      
                    <div class="pt-4 px-15 pb-6" >
                        @livewire('proximos_prestamos.tabla')
                    </div>
            </div>
            <div class="h-full relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        
        </div>
    </div>
</x-layouts::app>
