<div>
    {{-- It is never too late to be what you might have been. - George Eliot --}}
    <flux:table :paginate="$this->personal">
    {{-- header de la tabla --}}
        <flux:table.columns>
            <flux:table.column>ID</flux:table.column>
            <flux:table.column>Nombre</flux:table.column>
            <flux:table.column>Correo</flux:table.column>
            <flux:table.column>Rol</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>
    {{-- contenido de la tabla --}}
        <flux:table.rows>
            @forelse ($this->personal as $persona)
                <flux:table.row :key="$persona->id">
                    <flux:table.cell>{{ $persona->id }}</flux:table.cell>
                    <flux:table.cell>{{ $persona->name }}</flux:table.cell>
                    <flux:table.cell>{{ $persona->email }}</flux:table.cell>
                    <flux:table.cell>{{ $persona->role }}</flux:table.cell>
                    <flux:table.cell>
                        <button class="px-2 py-1 text-sm text-white bg-blue-500 rounded">Editar</button>
                        <button class="px-2 py-1 text-sm text-white bg-red-500 rounded">Eliminar</button>
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