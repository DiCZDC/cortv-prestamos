<x-layouts::app title="Crear Préstamo">
    @role('admin')
    {{-- navegacion interna --}}
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('prestamo.index') }}"><span class="!text-gris_claro dark:!text-hueso">Préstamos</span></flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#"><span class="!text-gris_claro dark:!text-hueso">Crear Préstamo</span>    </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    @endrole
        <livewire:prestamo.create.forms title="Initial Title" />  
</x-layouts::app >