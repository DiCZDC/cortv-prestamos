import Swiper from 'swiper/bundle';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css/bundle';

// Initialize Swiper
const swiper = new Swiper('.swiper', {
  modules: [Navigation, Pagination],
  loop: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});
