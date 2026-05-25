<?php

use Livewire\Component;


new class extends Component
{
    // public $images = [];

    // public function mount($images)
    // {
    //     $this->images = $images;
    // }
};
?>

@vite('resources/js/carousel.js')

<div class="swiper">
    {{-- Slider main container --}}
    <div class="swiper-wrapper">
        <!-- Slides -->
        @for ($i = 0; $i < 10 ; $i++)
            <div class="swiper-slide">
                <img src="https://placehold.co/600x400" alt="Slide">
            </div>
        @endfor
    </div>

    <!-- Pagination and navigation -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
</div>