$('.owl-carousel').owlCarousel({
  loop:true,
  margin: 10,
  responsiveClass:true,
  autoplay:true,
  autoplayTimeout:4000,
  autoplayHoverPause:true,
  responsive:{
      0: {
          items:1,
          loop: true,
          nav:false
      }
  }
})