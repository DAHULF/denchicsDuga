$(window).scroll(function() {

  var st = $(this).scrollTop();

  $(".BB").css({
    "transform" : "translate(0%, -" +st /8 + "%"
  });
});