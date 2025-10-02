/**
 * Initializes a Swiper instance for the image gallery slider.
 */
export function initImagegallery() {
  const galleryContainer = document.querySelector(".gallery-swiper");

  if (!galleryContainer) return;

  new Swiper(galleryContainer, {
    loop: false,
    spaceBetween: 16,
    slidesPerView: 1,
    grabCursor: true,
    autoHeight: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    autoplay: {
      delay: 9000,
      disableOnInteraction: true,
    },
  });
}

// Check if we are in an ACF block preview environment and hook into its render action.
if (window.acf) {
  window.acf.addAction(
    "render_block_preview/type=image-gallery",
    initImagegallery
  );
} else {
  document.addEventListener("DOMContentLoaded", initImagegallery);
}
