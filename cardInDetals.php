<?php

    error_reporting(0);

    $good_id;

    if(empty($_GET['good_id'])){
        
        //header('Location: index.php'); это потом срочно раскомментировать
        
        $good_id = 1; //а это потом срочно закомментировать
        
    }else{
        
        $good_id = $_GET['good_id'];
        
    }

    $data_base_problem = false;

    require('data_base_confings.php');

    $connect = mysqli_connect(DATA_BASE_HOST, DATA_BASE_USER, DATA_BASE_PASSWORD, DATA_BASE_NAME);

    $goodData;
    $goodImages;

    if(!$data_base_problem){
        
        $query = "SELECT good_name, good_opisation, good_price, good_attendance, is_good_aviable FROM goods_data WHERE good_id = {$good_id}";
        
        $result = mysqli_query($connect, $query) or $data_base_problem = true;
        
        $goodData = mysqli_fetch_array($result);
        
        $newAttendance = $goodData['good_attendance'] + 1;
        
        $query = "UPDATE goods_data SET good_attendance = {$newAttendance} WHERE good_id = {$good_id}";
        
        $result = mysqli_query($connect, $query) or $data_base_problem = true;
        
        $query = "SELECT image_way FROM goods_images WHERE goods_id = {$good_id} ORDER BY goods_avatar DESC";
        
        $goodImages = mysqli_query($connect, $query) or $data_base_problem = true;
        
    }

    mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/style.css">
  <link rel="stylesheet" href="style/cardindetal.css">
  <title>Document</title>
</head>
<body>
  <div class="block-and-slider">
      <div id="block-for-slider">
        <div id="viewport">
            <ul id="slidewrapper">
                <li class="slide"><img src="img/oneBG.jpg" alt="1" width="100%" height="600px"  class="slide-img"></li>
                <li class="slide"><img src="img/twoBG.jpg" alt="2" width="100%" height="600px" class="slide-img"></li>
                <li class="slide"><img src="img/threeBG.jpg" alt="3" width="100%" height="600px" class="slide-img"></li>
                <li class="slide"><img src="img/fourBG.jpg" alt="4" width="100%" height="600px" class="slide-img"></li>
                <li class="slide"><img src="img/fiveBG.jpg" alt="5" width="100%" height="600px" class="slide-img"></li>
                <li class="slide"><img src="img/sixBG.jpg" alt="6" width="100%" height="600px" class="slide-img"></li>
            </ul>

            <div id="prev-next-btns">
                <div id="prev-btn"></div>
                <div id="next-btn"></div>
            </div>
        </div>
    </div>
  </div>
  <div class="item-description-price-name" align="left">
    <h1 class="item-name">имя товара</h1>
    <p style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; font-size: 20px;">afdadfadfadasda
    авыаывываавыавыавав
    ававыаываываываывыа
    ывааывыаваываывыаваы
    ыавыаваываываываыаыв
    аываыаыаыаыаыаыаываыв

    </p>
      <div class="block-price">
        <h3 class="item-price">цена:</h3>
        <h2 class="item-price-count">990</h2>
    </div>
  </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        var slideNow = 1;
var slideCount = $('#slidewrapper').children().length;
console.log(slideCount)
var slideInterval = 3000;
var navBtnId = 0;
var translateWidth = 0;

$(document).ready(function() {
    var switchInterval = setInterval(nextSlide, slideInterval);

    $('#viewport').hover(function() {
        clearInterval(switchInterval);
    }, function() {
        switchInterval = setInterval(nextSlide, slideInterval);
    });

    $('#next-btn').click(function() {
        nextSlide();
    });

    $('#prev-btn').click(function() {
        prevSlide();
    });
});


function nextSlide() {
    if (slideNow == slideCount || slideNow <= 0 || slideNow > slideCount) {
        $('#slidewrapper').css('transform', 'translate(0, 0)');
        slideNow = 1;
    } else {
        translateWidth = -$('#viewport').width() * (slideNow);
        $('#slidewrapper').css({
            'transform': 'translate(' + translateWidth + 'px, 0)',
            '-webkit-transform': 'translate(' + translateWidth + 'px, 0)',
            '-ms-transform': 'translate(' + translateWidth + 'px, 0)',
        });
        slideNow++;
    }
}
function prevSlide() {
    if (slideNow == 1 || slideNow <= 0 || slideNow > slideCount) {
        translateWidth = -$('#viewport').width() * (slideCount - 1);
        $('#slidewrapper').css({
            'transform': 'translate(' + translateWidth + 'px, 0)',
            '-webkit-transform': 'translate(' + translateWidth + 'px, 0)',
            '-ms-transform': 'translate(' + translateWidth + 'px, 0)',
        });
        slideNow = slideCount;
    } else {
        translateWidth = -$('#viewport').width() * (slideNow - 2);
        $('#slidewrapper').css({
            'transform': 'translate(' + translateWidth + 'px, 0)',
            '-webkit-transform': 'translate(' + translateWidth + 'px, 0)',
            '-ms-transform': 'translate(' + translateWidth + 'px, 0)',
        });
        slideNow--;
    }
}
    </script>
</body>
</html>