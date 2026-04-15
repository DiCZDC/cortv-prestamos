@php
    $prestamo = \App\Models\Solicitud::find(request()->route('id'));
@endphp
<x-layouts::app title="Entregas">
    <div class="px-4">
        {{-- navegacion interna --}}
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('entrega.index') }}"><span class="!text-gris_claro">Entrega</span></flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#"><span class="!text-gris_claro">{{ $prestamo->motivo }}</span>    </flux:breadcrumbs.item>
            </flux:breadcrumbs>
    </div>
</x-layouts::app >