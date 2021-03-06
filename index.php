﻿<?php
		
    error_reporting(0);

    $sortId = 1;
    
    if(!empty($_GET['sort_id'])){
        
        $sortId = $_GET['sort_id'];
        
        if(($sortId > 3) || ($sortId < 1)){
            
            $sortId = 1;
            
        }
        
    }

    $goods_data_problem = false;

    require('data_base_confings.php');

    $connect = mysqli_connect(DATA_BASE_HOST, DATA_BASE_USER, DATA_BASE_PASSWORD, DATA_BASE_NAME) or $goods_data_problem = true;

    $goodsData;
    $goodsImages;

    if(!$goods_data_problem){
        
        $orderCommand;
        
        if($sortId == 2){
            
            $orderCommand = "good_name ASC";
            
        }else{
            
            $orderCommand = "good_id DESC";
            
        }
        
        $query = "SELECT good_id, good_name, good_opisation, good_price FROM goods_data WHERE is_good_aviable=1 ORDER BY {$orderCommand}";
        
        $goodsData = mysqli_query($connect, $query) or $goods_data_problem = true;
        
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="owl.carousel.min.css">
	<title>текстиль</title>
    
</head>
<body>
		<div class="one-block">
			<div class="block">
				<header>
					<div class="content">
						<h1 class="name">домашний текстиль</h1>
						<p class="nPhone">+7 (904) 214-82-18</p>
					</div>
					<div class="BG">
						<img src="img/oneBG.jpg" width="160" height="180" class="one-bg">
						<img src="img/twoBG.jpg" width="140" height="160" class="two-bg">
						<img src="img/threeBG.jpg" width="90" height="110" class="three-bg">
						<img src="img/fourBG.jpg" width="90" height="110" class="four-bg">
						<img src="img/fiveBG.jpg" width="140" height="160" class="five-bg">
						<img src="img/sixBG.jpg" width="160" height="130" class="six-bg">
					</div>
					<div class="BB">
						<img src="img/oneBB.jpg" width="140" height="160" class="one-bb">
						<img src="img/twoBB.jpg" width="120" height="140" class="two-bb">
						<img src="img/threeBB.jpg" width="90" height="90" class="three-bb">
						<img src="img/fourBB.jpg" width="90" height="110" class="four-bb">
						<img src="img/fiveBB.jpg" width="150" height="100" class="five-bb">
						<img src="img/sixBB.jpg" width="140" height="160" class="six-bb">
					</div>
				</header>
			</div>
		</div>
		<h1 class="whatSelling white">что мы продаем</h1>
		<div class="two-block">
			<div class=" border-wrapper">
				<div class="wrapper">
					<div class="cards" overflow-y:scroll>
						<div class="state">
                            
							<button class="itemBtn-news btn" onclick="location.href='<?php echo "{$_SERVER['PHP_SELF']}?sort_id=1"; ?>'">новинки</button>
                            
							<button class="itemBtn-premium btn" onclick="location.href='<?php echo "{$_SERVER['PHP_SELF']}?sort_id=2"; ?>'">по алфавиту</button>
                            
						</div>
                        <?php
                        
                            $row = mysqli_fetch_array($goodsData);
                        
                            $query = "SELECT image_way FROM goods_images WHERE goods_id={$row['good_id']}";
                            
                            $goodsImages = mysqli_query($connect, $query);
                        
                            if($goods_data_problem || !$row){
                                
                                echo "<h1 class='error'>ошибка, товары не найдены</h1>";
                                
                            }else{
                                
                                echo "<div class='card-item'>";
                                echo "<div class='owl-carousel owl-theme owl-close item-img'>";
                                
                                while($rowImg = mysqli_fetch_array($goodsImages)){
                                    
                                    echo "<img src='{$rowImg['image_way']}' class='item-img'>";
                                    
                                }
                                
                                echo "</div>";
                                echo "<div class='body-item'>";
                                echo "<h2 class='item-name'>{$row['good_name']}</h2>";
                                echo "<p class='item-descriprion'></p>";
                                echo $row['good_opisation'];
                                echo "</p>";
                                echo "<h3 class='item-price'>{$row['good_price']}р</h3>";
                                echo "</div>";
                                echo "</div>";
                                
                                while($row = mysqli_fetch_array($goodsData)){
                                    
                                    $query = "SELECT image_way FROM goods_images WHERE goods_id={$row['good_id']}";
                            
                                    $goodsImages = mysqli_query($connect, $query);
                                    
                                    echo "<div class='card-item'>";
                                    echo "<div class='owl-carousel owl-theme owl-close item-img'>";
                                    
                                    while($rowImg = mysqli_fetch_array($goodsImages)){
                                        
                                        echo "<img src='{$rowImg['image_way']}' class='item-img'>";
                                        
                                    }
                                    
                                    echo "</div>";
                                    echo "<div class='margin-item'>";
                                    echo "<h2 class='item-name'>{$row['good_name']}</h2>";
                                    echo "<p class='item-descriprion'>";
                                    echo $row['good_opisation'];
                                    echo "</p>";
                                    echo "<h3 class='item-price'>{$row['good_price']}р</h3>";
                                    echo "</div>";
                                    echo "</div>";
                                    
                                }
                                
                            }
                        
                        ?>
				</div>
				</div>
		<div class="two-block">
		<div class="map">
			<div class="map-name-block">
				<h1 class="map-name">мы на картах</h1>
			</div>
			<iframe class="mainMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2470.651178783211!2d39.309211654928504!3d51.73941519012627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x413b244fb6eedd31%3A0xef6eb1901cff5a3d!2z0YPQuy4g0KTRkdC00L7RgNCwINCi0Y7RgtGH0LXQstCwLCA5NdCcLCDQktC-0YDQvtC90LXQtiwg0JLQvtGA0L7QvdC10LbRgdC60LDRjyDQvtCx0LsuLCAzOTQwNTA!5e0!3m2!1sru!2sru!4v1581964101336!5m2!1sru!2sru" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
		</div>
		<footer>
			<p class="nPhone footerPhone">контакты
			<br><a class="vk-href" href="https://vk.com/club132873597">группа вконтакте</a>
			<br>+7 (904) 214-82-18</p>
		</footer>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<script src="owl.carousel.min.js"></script>
        <script src="javascript.js"></script>
		<script src="scroll.js"></script>
</body>
</html>

