<x-layouts::app title="Equipo">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('equipo.index') }}">Equipo</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Ver Equipo {{$id}}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
</x-layouts::app>
