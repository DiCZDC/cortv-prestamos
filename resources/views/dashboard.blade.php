<x-layouts::app :title="__('Dashboard')">
    @role('admin')
        @include('dashboard.admin')

    @endrole
    @role('trabajador')
        @include('dashboard.trabajador')
    @endrole
</x-layouts::app>
