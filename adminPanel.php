<?php

    session_start();

    $exchange_good = false;

    $good_info;
    $good_images;

    $goodsData;
    $goodsImages;
    
    require('data_base_confings.php');

    $connect = mysqli_connect(DATA_BASE_HOST, DATA_BASE_USER, DATA_BASE_PASSWORD, DATA_BASE_NAME);

    if(empty($_SESSION['admins_id'])){
        
        header("Location: admin.php");
        
    }else{
        
        $query = "SELECT users_name FROM users WHERE users_id={$_SESSION['admins_id']}";
        
        $result = mysqli_query($connect, $query);
        
        if(!$row = mysqli_fetch_array($result)){
            
            header("Location: admin.php");
            
        }
        
    }

    if(!empty($_GET['good_id'])){
        
        $exchange_good = true;
        
        $query = "SELECT good_name, good_opisation, good_price, is_good_aviable FROM goods_data WHERE good_id={$_GET['good_id']}";
        
        $result = mysqli_query($connect, $query);
        
        if(!$good_info = mysqli_fetch_array($result)){
            
            $exchange_good = false;
            
        }
        
        $query = "SELECT image_way FROM goods_images WHERE goods_id={$_GET['good_id']}";
        
        $good_images = mysqli_query($connect, $query);
        
    }

    $query = "SELECT good_id, good_name, good_opisation, good_price, is_good_aviable FROM goods_data";
        
    $goodsData = mysqli_query($connect, $query) or $goods_data_problem = true;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/admin.css">
  <link rel="stylesheet" href="owl.carousel.min.css">
  <link rel="stylesheet" href="style/item.css">
  <link rel="stylesheet" href="style/style.css">
  <title>Document</title>
</head>
<body>
<div class="create-card">
    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        
      <textarea type="pattern" placeholder="описание" class="description-item" rows="0" maxlength="600"><?php if($exchange_good) echo $good_info['good_opisation']; ?></textarea>
      <?php
        if($exchange_good){ 
            
            echo '<input type="submit" class="btn btn-submit" name="changeOld" value="Обновить"/>';
            
        }else{
            
            echo '<input type="submit" class="btn btn-submit" name="createNew" value="создать"/>';
            
        }
        ?>
      <!-- <input type="submit" class="btn btn-submit" name="createNew" value="создать"/> -->
      <?php 
        
        //$image = mysqli_fetch_array($good_images);
        //echo "<img src='{$image['image_way']}' />";
        
      ?>
      <input type="file" class="one-import file-item">
      <?php //echo mysqli_fetch_array($good_images); ?>
      <input type="file" class="two-import file-item">
      <?php// echo mysqli_fetch_array($good_images); ?>
      <input type="file" class="three-import file-item">
      <?php //echo mysqli_fetch_array($good_images); ?>
      <input type="file" class="four-import file-item">
      <?php //echo mysqli_fetch_array($good_images); ?>
      <input type="file" class="five-import file-item">
      <?php //echo mysqli_fetch_array($good_images); ?>
      <input type="file" class="six-import file-item">
      <input type="text" placeholder="название" <?php if($exchange_good) echo "value='{$good_info['good_name']}'"; ?> class="txt-item txt-name">
      <input type="number" placeholder="цена" <?php if($exchange_good) echo "value='{$good_info['good_price']}'"; ?> class="txt-item txt-price">
        
    </form>
    
  </div>
    
  <div class="wrapper">
    <div class="cards">
        <?php
            
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
                echo "<div class='editor'>";
                echo "<div class='delete-item'>удалить</div>";
                echo "<div class='edit-item'>редактировать</div>";
                echo "</div>";
                echo "<p class='item-descriprion'>";
                echo $row['good_opisation'];
                echo "</p>";
                echo "<h3 class='item-price'>{$row['good_price']}р</h3>";
                echo "</div>";
                echo "</div>";
                
            }
        
        ?>
        <div class='card-item'>
          <div class="owl-carousel owl-theme owl-close item-img">
              <img src="img/oneBB.jpg" class='item-img'>
              <img src="img/twoBB.jpg" class='item-img'>
              <img src="img/threeBB.jpg" class='item-img'>
              <img src="img/fourBB.jpg" class='item-img'>
              <img src="img/fiveBB.jpg" class='item-img'> 
              <img src="img/sixBB.jpg" class='item-img'>
          </div>
          <div class='margin-item'>
            <h2 class='item-name'>тест</h2>
            <div class="editor">
              <div class="delete-item">удалить</div>
              <div class="edit-item">редактировать</div>
            </div>
            <p class="item-descriprion">
              dssdaasd sadklas dld;jad asdjll;dldjldasjljasdl;djasl
            </p>
            <h3 class="item-price">400р</h3>

          </div>
      </div>
  </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="owl.carousel.min.js"></script>
  <script src="javascript.js"></script>
</body>
</html>