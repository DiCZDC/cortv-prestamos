@php
    $hoy    = now()->toDateString();

@endphp

<div class="bg-white rounded-xl shadow-xl p-4 w-72">

    {{-- Cabecera mes/año --}}
    <div class="flex items-center justify-around mb-3">
        
        <button wire:click="mesAnterior"
            class="p-1 hover:bg-gray-100 rounded"
            {{-- {{ ! $puedeIrAnterior ? 'cursor-not-allowed opacity-50' : '' }}
            {{ ! $puedeIrAnterior ? 'disabled' : '' }} --}}
            >
            <flux:icon.chevron-left class="!text-black"/>
        </button>

        <span class="font-semibold text-md capitalize text-black">
            {{ ucfirst($nombreMes) }} {{ $anio }}
        </span>
        
        <button wire:click="mesSiguiente"
            class="p-1 hover:bg-gray-100 rounded 
            "
            {{-- {{ ! $puedeIrSiguiente ? 'cursor-not-allowed opacity-50' : '' }}
            {{ ! $puedeIrSiguiente ? 'disabled' : '' }} --}}
            >
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
                    $cant = $dia ? $this->fechasApartadas->get($this->createDate($dia, $mes, $anio))->total_equipos ?? 0 : 0;
                @endphp
                <div class="h-8 w-8 mx-auto rounded-xl text-sm transition-colors flex items-center justify-center
                        {{  now()->toDateString() === $this->createDate($dia, $mes, $anio) ? ' bg-azul_oscuro  text-hueso' :
                            ($cant >= 5 ? 'bg-rose-100' :
                                ($cant >= 3 ? 'bg-emerald-100' :
                                    ($cant > 0 ? 'bg-amber-100' : '')))
                        }}
                        {{-- {{ $esInicio || $esFin ? 'bg-azul_oscuro text-white font-bold' : '' }} --}}
                        {{-- {{ $enRango ? 'bg-azul_oscuro/8 text-black rounded-xl' : '' }} --}}
                         "> 
                    {{ $dia}}
                </div>
            @endif
        @endforeach
    </div>
    <div class="mt-4">
        <h1>
            Cantidad de equipos a entregar por dia:
        </h1>
        <p class="text-sm text-gray-500 mt-2">
            <span class="inline-flex items-center gap-5">
                <span class="h-4 w-4 bg-amber-300 rounded-sm"></span>
                1-2 equipos por entregar
            </span>
            <br>
            <span class="inline-flex items-center gap-5">
                <span class="h-4 w-4 bg-emerald-300 rounded-sm"></span>
                3-4 equipos por entregar
            </span>
            <br>
            <span class="inline-flex items-center gap-5">
                <span class="h-4 w-4 bg-rose-300 rounded-sm"></span>
                5 o más equipos por entregar
            </span>
        </p>
    </div>
    
</div>