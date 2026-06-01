<x-layouts::app :title="__('Prestamos Pendientes')">
    {{-- div general --}}
    <div class="
    {{-- px-2  --}}
    lg:px-2
    py-3.5 flex flex-col gap-3">
        {{-- header --}}
        <div class="flex w-full pr-5 justify-between mb-4 
            gap-10 items-center flex-col-reverse
            md:flex-row md:gap-8.5
        ">
            {{-- info de la vista --}}
            <div class="flex flex-col justify-center gap-6 pl-3 w-full">
                
                <x-componentes.titulo icono="layers" texto="Prestamos" />
                
                <div class="flex flex-col gap-6 w-full justify-center sm:gap-0 sm:flex-row sm:justify-between sm:pr-5 ">
                        
                        <x-componentes.subtitulo icono="book-alert" texto="Prestamos pendientes de aprobar" />
                        
                        <flux:button 
                            href="{{ route('prestamo.create') }}"
                            icon="book-up" 
                            class=" bg-rojo-si! text-rojo-negacion! font-bold text-sm! border-none!
                            dark:bg-red-400/20! dark:text-red-200!
                            dark:hover:bg-red-400/30! dark:hover:bg-red-400/50!
                            
                            hover:bg-rojo-negacion! 
                            hover:text-hueso! 
                            transition-all duration-200 ease-out delay-150
                            hover:-translate-y-1.5 active:scale-95 cursor-pointer">
                            Crear nuevo prestamo
                        </flux:button>

                </div>

            </div>
        
        </div>

        {{-- tabla --}}
        <div class="w-full not-dark:bg-white rounded-lg not-dark:shadow-md p-8 mt-3">
            <livewire:prestamo.index.table lazy />
        </div>

        
    </div>
</x-layouts::app>
