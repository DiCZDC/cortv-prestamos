<x-layouts::app title="Crear Préstamo">
{{-- navegacion interna --}}
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('prestamo.index') }}"><span class="!text-gris_claro dark:!text-hueso">Préstamos</span></flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#"><span class="!text-gris_claro dark:!text-hueso">Crear Préstamo</span>    </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    <livewire:solicitud.forms title="Initial Title" />  
</x-layouts::app >