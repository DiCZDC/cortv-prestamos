@php
    $user = App\Models\User::findOrFail($id);
    $filter = null;
@endphp
<x-layouts::app title="Personal">
    <!-- An unexamined life is not worth living. - Socrates -->
    <div class="px-4">
        {{-- navegacion interna --}}
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('personal.index') }}"><span class="!text-gris_claro">Personal</span></flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#"><span class="!text-gris_claro">{{ $user->name }}</span>    </flux:breadcrumbs.item>
            </flux:breadcrumbs>
    
        <div class="flex flex-col justify-center gap-8.5 pl-3 mt-10 mb-6 ">
            <x-componentes.titulo icono="id-card-lanyard" texto="Usuario" />
            <x-componentes.subtitulo icono="user" texto="{{ $user->name }}" />
        </div>
        
        @if($user->hasRole('trabajador'))
            <livewire:personal.show.data :id="$id" />
        @endif
</div>
