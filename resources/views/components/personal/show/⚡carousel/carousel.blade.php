@vite('resources/js/carousel.js')

<div class="swiper
    shadow-lg rounded-2xl 
    {{-- bg-white --}}
    dark:bg-gris_oscuro
    "
    style="
        width: 580px;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        justify-content: space-between;
        overflow: hidden;
    "
>
    <div class="swiper-wrapper"
        style="
            width: 540px;
            height: 100%;
        "   
    >
        <!-- Slides -->
        @forelse ($this->historial_prestamos as $prestamo)
        <div class="swiper-slide"
            style="
                display: flex;
                flex-flow: column wrap;
            "
        >
            <livewire:personal.show.card
                :titulo="$prestamo['titulo']"
                :subtitulo="$prestamo['subtitulo']"
                :date="$prestamo['date']"
                :pill="$prestamo['pill']"
                :route="$prestamo['route']"
                />
        </div>
        @empty
        <div class="swiper-slide"
            style="
                display: flex;
                flex-flow: column wrap;
                justify-content: center;
                align-items: center;
            "
        >
            <p class="text-lg text-gris_claro">No hay prestamos en curso</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination and navigation -->
    <div class="swiper-button-prev"
        style="
            color: #8B2427; /* Cambia el color si lo deseas */
            width: 15px;
        "
    ></div>
    <div class="swiper-pagination"
        style="
            color: #8B2427; /* Cambia el color si lo deseas */
        "
    ></div>
    <div class="swiper-button-next"
        style="
            color: #8B2427; /* Cambia el color si lo deseas */
            width: 15px;
        "
    ></div>
</div>