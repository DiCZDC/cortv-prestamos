import Swiper from 'swiper/bundle';
import { Navigation, Pagination, Mousewheel } from 'swiper/modules';
import 'swiper/css/bundle';

const swiper = new Swiper('.swiper', {
  modules: [Navigation, Pagination, Mousewheel],
  loop: true,
  mousewheel: {
    forceToAxis: true,
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});
