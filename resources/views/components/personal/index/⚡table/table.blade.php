<div>
    {{-- It is never too late to be what you might have been. - George Eliot --}}
    @placeholder
        <x-placeholder.table 
            :header="['ID', 'Nombre', 'Correo', 'Rol', 'Acciones']" 
            filter=true 
            perPage=10
        />
    @endplaceholder
    
    <livewire:componentes.searchbar
        placeholder="Buscar por nombre de trabajador o correo..."
    />
    
    <flux:table :paginate="$this->personal">
    {{-- header de la tabla --}}
        <flux:table.columns>
            <x-componentes.header_table> ID </x-componentes.header_table>
            <x-componentes.header_table icon="id-card">Nombre</x-componentes.header_table>
            <x-componentes.header_table icon="mail">Correo</x-componentes.header_table>
            <x-componentes.header_table icon="contact-round">Rol</x-componentes.header_table>
            <x-componentes.header_table icon="target">Acciones</x-componentes.header_table>
        </flux:table.columns>
    {{-- contenido de la tabla --}}
        <flux:table.rows>
            @forelse ($this->personal as $persona)
                <flux:table.row :key="$persona->id">
                    <flux:table.cell>{{ $persona->id }}</flux:table.cell>
                    <flux:table.cell>{{ $persona->name }}</flux:table.cell>
                    <flux:table.cell>{{ $persona->email }}</flux:table.cell>
                    
                    <flux:table.cell class="flex items-center gap-1">
                        <flux:icon :name="$persona->roles->first()?->name == 'admin' ? 'shield-user' : 
                                        ($persona->roles->first()?->name ? 'user' : 'user-x')"
                        size="sm" class="mr-1" />
                        {{ $persona->roles->first()?->name ?? 'Sin rol' }}
                    </flux:table.cell>
                    
                    <flux:table.cell>
                        {{-- <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button> --}}
                        <x-componentes.boton-href ruta="personal.show" texto="Ver" icon="eye" :id="$persona->id" />    
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
</div>