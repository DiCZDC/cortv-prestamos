<div class="
    flex-1 h-full py-2.5 gap-10 -mt-px -ml-px flex items-center justify-center bg-rojo_claro text-hueso rounded-lg"
    {{-- style="min-width: 10rem;" --}}
     >

    <p class="text-lg font-bold">
        {{ 
            match($day->format('w')){
                default => 'Desconocido',
                '0'=>'Domingo',
                '1'=>'Lunes',
                '2'=>'Martes',
                '3'=>'Miércoles',
                '4'=>'Jueves',
                '5'=>'Viernes',
                '6'=>'Sábado',
            }
        }}
    </p>

</div>
