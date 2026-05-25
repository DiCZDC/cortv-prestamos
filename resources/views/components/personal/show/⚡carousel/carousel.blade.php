@vite('resources/js/carousel.js')

<div class="swiper">
    {{-- Slider main container --}}
    <div class="swiper-wrapper">
        <!-- Slides -->
        @foreach ($this->historial_prestamos as $prestamo)
        <div class="swiper-slide flex justify-center items-center w-1/2 h-full ">
            {{-- <img src="https://placehold.co/750x400" alt="Slide"> --}}
            <livewire:personal.show.card 
                {{-- :prestamo_en_curso="$this->prestamo_en_curso"  --}}
                :titulo="$prestamo['titulo']"
                :subtitulo="$prestamo['subtitulo']"
                :date="$prestamo['date']"
                :pill="$prestamo['pill']"
                :route="$prestamo['route']"
                />
        </div>
        @endforeach
    </div>

    <!-- Pagination and navigation -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
</div>