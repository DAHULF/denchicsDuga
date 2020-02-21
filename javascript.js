
$(window).scroll(function() {

  var st = $(this).scrollTop();

  $(".BB").css({
    "transform" : "translate(0%, -" +st /5 + "%"
  });
  $(".one-block").css({
    "transform" : "translate(0%, -" +st /15 + "%"
  });
  $(".two-block").css({
    "transform" : "translate(0%, +" +st /140 + "%"
  });
  $(".whatSelling").css({
    "transform" : "translate(0%, +" +st /5 + "%"
  })
});
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