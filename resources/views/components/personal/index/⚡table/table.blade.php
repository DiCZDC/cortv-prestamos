<div class="px-2" >
    {{-- It is never too late to be what you might have been. - George Eliot --}}
    @placeholder
        <x-placeholder.table 
            :header="['ID', 'Nombre', 'Correo', 'Rol', 'Acciones']" 
            filter=true 
            perPage=6
        />
    @endplaceholder
    
    <livewire:componentes.searchbar
        placeholder="Buscar por nombre de trabajador o correo..."
        :filters="[
            'all' => 'Todos', 
            'admin' => 'Administradores', 
            'trabajador' => 'Trabajadores'
            ]"
    />
    
    <flux:table :paginate="$this->personal">
    {{-- header de la tabla --}}
        <flux:table.columns>
            <x-componentes.header_table> ID </x-componentes.header_table>
            <x-componentes.header_table icon="id-card">Nombre</x-componentes.header_table>
            <x-componentes.header_table icon="mail">Correo</x-componentes.header_table>
            <x-componentes.header_table icon="user-round-key" sortable="rol" :sortBy="$sortBy" :sortDirection="$sortDirection">Rol</x-componentes.header_table>
            <x-componentes.header_table icon="target">Acciones</x-componentes.header_table>
        </flux:table.columns>
    {{-- contenido de la tabla --}}
        <flux:table.rows>
            @forelse ($this->personal as $persona)
                <flux:table.row :key="$persona->id">
                    <flux:table.cell>{{ $persona->id }}</flux:table.cell>
                    <flux:table.cell>{{ $persona->name }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="zinc" >
                            {{ $persona->email }}
                        </flux:badge>
                    </flux:table.cell>
                    
                    <flux:table.cell class="flex items-center! py-5!">

                        <flux:badge :color="match($persona->roles->first()?->name) {
                            'admin' => 'blue',
                            'trabajador' => 'cyan',
                            default => 'zinc'
                        }">

                            <flux:icon :name="match($persona->roles->first()?->name) {
                                'admin' => 'shield-user',
                                'trabajador' => 'contact-round',
                                default => 'user-round-x'
                            }"
                            
                            size="sm" class="mr-1" />
                            {{ match($persona->roles->first()?->name) {
                                'admin' => 'Administrador',
                                'trabajador' => 'Trabajador',
                                default => 'Sin rol'
                            } }}

                        </flux:badge>

                    </flux:table.cell>
                    
                    <flux:table.cell class="flex-row  gap-4">
                        
                        <div class="flex gap-5">
                            <flux:modal.trigger name="update-role.{{ $persona->id }}">
                                <flux:button 
                                    variant="outline" 
                                    icon:trailing="user-pen" 
                                    class="bg-[#fff1bf]! text-[#bb4d00]! 
                                            font-bold text-sm! border-none!
                                            hover:bg-[#FAA543]! 
                                            hover:text-white!
                                            transition all delay-100 duration-200 ease-out  
                                            hover:-translate-y-1.5 active:scale-92 cursor-pointer"
                                    >
                                    Cambiar rol
                                </flux:button>
                            </flux:modal.trigger>

                            <flux:modal.trigger name="reset-password.{{ $persona->id }}">
                                <flux:button 
                                    variant="outline" 
                                    icon:trailing="refresh-ccw"    
                                    class="bg-[#ede6ff]! text-[#7008e7]! 
                                            font-bold text-sm! border-none!
                                            hover:bg-[#7008e7]! 
                                            hover:text-white!
                                            transition all delay-100 duration-200 ease-out  
                                            hover:-translate-y-1.5 active:scale-92 cursor-pointer"
                                    >
                                    Restablecer contraseña
                                </flux:button>
                            </flux:modal.trigger>

                            <x-componentes.boton-href ruta="personal.show" texto="Ver" icon="eye" :id="$persona->id" />    
                                
                                
                            </div>
                            
                        <livewire:personal.index.modal :persona="$persona" />
                        <livewire:personal.index.modal_reset_password :persona="$persona"/>
                        
                    </flux:table.cell>
                </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center">
                        No hay personal registrado.
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
        <flux:select size="sm" class="mt-0.5 w-full sm:w-auto" wire:model.live="perPage">
            <flux:select.option value="6">6</flux:select.option>
            <flux:select.option value="12">12</flux:select.option>
            <flux:select.option value="24">24</flux:select.option>
            <flux:select.option value="48">48</flux:select.option>
        </flux:select>
</div>