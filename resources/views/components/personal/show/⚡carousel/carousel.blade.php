@vite('resources/js/carousel.js')

<div
    class="
        [--swiper-pagination-color:#8B2427]
        dark:[--swiper-pagination-color:#AE2B2F]
        [--swiper-navigation-size:18px]
        lg:[--swiper-navigation-size:24px]
    "
    style="display: flex; align-items: center; width: 100%; gap: 4px; justify-content: center;"
>

    <div class="swiper-button-prev text-rojo_oscuro dark:text-rojo_claro"
        style="
            position: relative;
            top: auto;
            left: auto;
            flex-shrink: 0;
        "
    ></div>

    <div class="swiper
        shadow-lg rounded-2xl
        bg-hueso
        dark:bg-gris_oscuro
        "
        style="
            flex: 1;
            min-width: 0;
            overflow: hidden;
        "
    >
        <div class="swiper-wrapper">
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
                <p class="text-lg text-gris_claro dark:text-zinc-400">No hay prestamos en curso</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>

    <div class="swiper-button-next text-rojo_oscuro dark:text-rojo_claro"
        style="
            position: relative;
            top: auto;
            right: auto;
            flex-shrink: 0;
        "
    ></div>
</div>
