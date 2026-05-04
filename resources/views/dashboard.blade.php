<x-layouts::app :title="__('Inicio')">
    @role('admin')
        @include('vistas.dashboard.admin')
    @elserole('trabajador')
        @include('vistas.dashboard.trabajador')
    @else
        <div class="h-full items-center justify-center flex flex-col">
            <flux:callout variant="danger" icon="x-circle" 
                class="w-full text-center"
                heading="No tienes permisos para acceder a la plataforma, solicita acceso a un administrador."
             />
                <img src="https://reactiongifs.com/r/waiting.gif" alt="Esperando" class="mx-auto mt-4">
        </div>
    @endrole

</x-layouts::app>
