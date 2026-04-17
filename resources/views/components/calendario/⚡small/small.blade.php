@php
    $solicitud = $this->solicitud();

    $inicio = $solicitud?->fecha_prestamo;
    $fin    = $solicitud?->fecha_devolucion;
    $hoy    = now()->toDateString();

    $inicioMes = $inicio ? \Carbon\Carbon::parse($inicio)->startOfMonth() : null;
    $finMes    = $fin ? \Carbon\Carbon::parse($fin)->startOfMonth() : null;
    $mesVista  = \Carbon\Carbon::createFromDate($this->anio, $this->mes, 1)->startOfMonth();

    // Solo permitir navegación si el rango cubre más de un mes
    $abarcaMasDeUnMes = $inicioMes && $finMes && ! $inicioMes->equalTo($finMes);

    // Limitar navegación al rango [inicioMes, finMes]
    $puedeIrAnterior  = $abarcaMasDeUnMes && $mesVista->greaterThan($inicioMes);
    $puedeIrSiguiente = $abarcaMasDeUnMes && $mesVista->lessThan($finMes);
@endphp

<div class="bg-white rounded-xl shadow-xl p-4 w-72">

    {{-- Cabecera mes/año --}}
    <div class="flex items-center justify-around mb-3">
        
        <button wire:click="mesAnterior"
            class="p-1 hover:bg-gray-100 rounded {{ ! $puedeIrAnterior ? 'cursor-not-allowed opacity-50' : '' }}"
            {{ ! $puedeIrAnterior ? 'disabled' : '' }}>
            <flux:icon.chevron-left class="!text-black"/>
        </button>

        <span class="font-semibold text-md capitalize text-black">
            {{ ucfirst($nombreMes) }} {{ $anio }}
        </span>
        
        <button wire:click="mesSiguiente"
            class="p-1 hover:bg-gray-100 rounded {{ ! $puedeIrSiguiente ? 'cursor-not-allowed opacity-50' : '' }}"
            {{ ! $puedeIrSiguiente ? 'disabled' : '' }}>
            <flux:icon.chevron-right class="!text-black"/>
        </button>
    </div>

    {{-- Días de la semana --}}
    <div class="grid grid-cols-7 text-center text-xs text-gray-500 mb-1">
        @foreach(['Dom','Lun','Mar','Mie','Jue','Vie','Sab'] as $d)
            <div>{{ $d }}</div>
        @endforeach
    </div>

    {{-- Días del mes --}}
    <div class="grid grid-cols-7 gap-0.5 text-center text-sm text-black">
        @foreach($dias as $dia)
            @if($dia === null)
                <div></div>
            @else
                @php
                    $fecha  = \Carbon\Carbon::createFromDate($anio, $mes, $dia)->toDateString();
                    
                    $esInicio = $fecha === $inicio;
                    $esFin    = $fecha === $fin;
                    $enRango  = $inicio && $fin && $fecha > $inicio && $fecha < $fin;
                    $esHoy    = $fecha === $hoy;
                @endphp

                <div class="h-8 w-8 mx-auto rounded-xl text-sm transition-colors flex items-center justify-center
                        {{ $esInicio || $esFin ? 'bg-azul_oscuro text-white font-bold' : '' }}
                        {{ $enRango ? 'bg-azul_oscuro/8 text-black rounded-xl' : '' }}
                        {{ $esHoy  ? 'border border-azul_oscuro text-azul_oscuro' : '' }}"> 
                    {{ $dia }}
                </div>
            @endif
        @endforeach
    </div>

    {{-- Periodo seleccionado --}}
    
    <div class="mt-3 text-xs text-zinc-600 border-t pt-3 flex flex-col gap-1">
        <p class="inline-flex items-center gap-3"> <flux:icon.calendars /> <span class="font-bold ">Inicio del prestamo:</span> <span>{{ $this->solicitud()->fecha_prestamo }}</span></p>
        <p class="inline-flex items-center gap-3">  <flux:icon.calendar-clock /> <span class="font-bold">Fin del prestamo:</span> <span>{{ $this->solicitud()->fecha_devolucion }}</span></p>
    </div>
    
</div>