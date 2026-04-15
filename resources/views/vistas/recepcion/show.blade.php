@php
    $prestamo = \App\Models\Solicitud::find(request()->route('id'));
@endphp
<x-layouts::app title="Mostrar Préstamo">
    <div class="px-4">
        {{-- navegacion interna --}}
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('recepcion.index') }}"><span class="!text-gris_claro">Recepción</span></flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#"><span class="!text-gris_claro">{{ $prestamo->motivo }}</span>    </flux:breadcrumbs.item>
            </flux:breadcrumbs>
    </div>
</x-layouts::app >