@php
    $Solicitud = App\Models\Solicitud::find($id);
@endphp

<x-layouts::app title="Archivo">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('archivo.index') }}">Archivo</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">{{ $Solicitud->motivo. ' - ' . $Solicitud->fecha_prestamo }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
</x-layouts>
