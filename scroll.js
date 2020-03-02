
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