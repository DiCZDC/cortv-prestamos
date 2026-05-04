<x-layouts::app :title="__('Inicio')">
    @role('admin')
        @include('vistas.dashboard.admin')
    @elserole('trabajador')
        @include('vistas.dashboard.trabajador')
    @else
        <flux:callout variant="danger" icon="x-circle" 
            heading="No tienes permisos para acceder a la plataforma, solicita acceso a un administrador."
         />
            <img src="https://reactiongifs.com/r/waiting.gif" alt="Pepe Laughing" class="mx-auto mt-4">
    @endrole

</x-layouts::app>
