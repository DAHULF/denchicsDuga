<?php

    session_start();

    //option variables

    $exchange_good = false;

    $good_info;

    $goodsData;
    $goodsImages;

    $isAddingOrUpdating = false;
    $addOrUpdateProblem = false;

    //data variables

    $goodName = '';
    $goodPrice = 0;
    $goodOpisation = '';

    $goodName;
    $goodPrice;
    $goodOpisation;

    //BASE TURNING ON
    
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
        
        $_SESSION['good_id'] = $_GET['good_id'];
        
        $exchange_good = true;
        
        $query = "SELECT good_id, good_name, good_opisation, good_price, is_good_aviable FROM goods_data WHERE good_id={$_GET['good_id']}";
        
        $result = mysqli_query($connect, $query);
        
        if(!$good_info = mysqli_fetch_array($result)){
            
            $exchange_good = false;
            
        }
        
        
    }

    $query = "SELECT good_id, good_name, good_opisation, good_price, is_good_aviable FROM goods_data ORDER BY good_id DESC";
        
    $goodsData = mysqli_query($connect, $query) or $goods_data_problem = true;

    //POSTS-QUERYS HANDLERS 

    //add if block

    if(isset($_POST['createNew'])){
        
        $isAddingOrUpdating = true;
        
        $goodName = mysqli_real_escape_string($connect, trim($_POST['goodName']));
        $goodPrice = mysqli_real_escape_string($connect, trim($_POST['goodPrice']));
        $goodOpisation = mysqli_real_escape_string($connect, trim($_POST['goodOpisation']));
        
        if(empty($goodName) || empty($goodPrice) || empty($goodOpisation)){
            
            $addOrUpdateProblem = true;
            
        }
        
        if(!$addOrUpdateProblem){
            
            $query = "INSERT INTO goods_data(good_name, good_opisation, good_price) VALUES('$goodName', '$goodOpisation', '$goodPrice')";
            
            $result = mysqli_query($connect, $query) or $addOrUpdateProblem = true;
            
            if(!$addOrUpdateProblem){
                
                $_SESSION['good_id'] = null;
                $_SESSION['image_num'] = 1;
                
                header('Location: importimages.php');
                
            }
            
        }
        
    }

    //update if block

    if(isset($_POST['changeOld'])){
        
        $goodName = mysqli_real_escape_string($connect, trim($_POST['goodName']));
        $goodPrice = mysqli_real_escape_string($connect, trim($_POST['goodPrice']));
        $goodOpisation = mysqli_real_escape_string($connect, trim($_POST['goodOpisation']));
        
        if(empty($goodName) || empty($goodPrice) || empty($goodOpisation)){
            
            $addOrUpdateProblem = true;
            
        }
        
        if(!$addOrUpdateProblem){
            
            $query = "UPDATE goods_data SET good_name='$goodName', good_opisation='$goodOpisation', good_price='$goodPrice' WHERE good_id='{$_SESSION['good_id']}'";
            
            $result = mysqli_query($connect, $query) or $addOrUpdateProblem = true;
            
        }
        
    }

    //change aviable if block

    if(isset($_POST['changeAviable'])){
        
        $newAviable = 1;
        
        $query = "SELECT is_good_aviable FROM goods_data WHERE good_id={$_SESSION['good_id']}";
        $result = mysqli_query($connect, $query);
        $row = mysqli_fetch_array($result);
        
        if($row['is_good_aviable'] == 1) $newAviable = 0;
        else $newAviable = 1;
        
        $query = "UPDATE goods_data SET is_good_aviable='$newAviable' WHERE good_id='{$_SESSION['good_id']}'";
        
        $result = mysqli_query($connect, $query) or $addOrUpdateProblem = true;
        
    }

    //redownload images if block

    if(isset($_POST['redownloadImg'])){
        
        $query = "SELECT image_way FROM goods_images WHERE goods_id={$_SESSION['good_id']}";
        $result = mysqli_query($connect, $query) or $addOrUpdateProblem = true;
        
        while($row = mysqli_fetch_array($result)){
            
            @unlink($row['image_way']);
            
        }
        
        $query = "DELETE FROM goods_images WHERE goods_id={$_SESSION['good_id']}";
        $result = mysqli_query($connect, $query) or $addOrUpdateProblem = true;
        
        if(!$addOrUpdateProblem){
            
             $_SESSION['image_num'] = 1;
             
             header('Location: importimages.php');
                
        }
        
    }

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
  <title>панель импорта</title>
</head>
<body>
<div class="create-card">
    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        
      <textarea type="pattern" placeholder="описание" class="description-item" rows="0" maxlength="600" name="goodOpisation"><?php if($exchange_good) echo $good_info['good_opisation'];?></textarea>
      <?php
        
        
            
        if($exchange_good){
            
            $button_value;
            
            if($good_info['is_good_aviable'] == 0){ 
            
                 $button_value = 'В наличие';
                 
             }else{
                 
                 $button_value = 'Не в наличие';
                 
             }
            
            echo '<input type="submit" class="btn btn-submit" name="changeOld" value="Обновить"/>';
            echo "<input type='submit' class='btn btn-submit' name='changeAviable' value='{$button_value}'/>";
            echo '<input type="submit" class="btn btn-submit" name="redownloadImg" value="Заного фотогр."/>';
            
        }else{
            
            echo '<input type="submit" class="btn btn-submit" name="createNew" value="создать"/>';
            
        }
        ?>
      <!-- <input type="submit" class="btn btn-submit" name="createNew" value="создать"/> -->
        
      <?php
        
        if($isAddingOrUpdating && $addOrUpdateProblem){
            
             echo "Во время добавления или обновления товара произошла ошибка";  
            
        }
        
      ?>
      <?php 
        
        // if(!$exchange_good){
            
        //     echo '<input type="file" class="one-import file-item" name="oneImg">';
        //     echo '<input type="file" class="two-import file-item" name="twoImg">';
        //     echo '<input type="file" class="three-import file-item" name="threeImg">';
        //     echo '<input type="file" class="four-import file-item" name="fourImg">';
        //     echo '<input type="file" class="five-import file-item" name="fiveImg">';
        //     echo '<input type="file" class="six-import file-item" name="sixImg">';
            
        // }
        
      ?>
      
      <input type="text" placeholder="название" <?php if($exchange_good) echo "value='{$good_info['good_name']}'";?> class="txt-item txt-name" name="goodName">
      <input type="number" placeholder="цена" <?php if($exchange_good) echo "value='{$good_info['good_price']}'";?> class="txt-item txt-price" name="goodPrice">
        
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
                echo "<div class='delete-item' onClick=\"window.location.href='cardDelete.php?good_id={$row['good_id']}'\">удалить</div>";
                echo "<div class='edit-item' onClick=\"window.location.href='{$_SERVER['PHP_SELF']}?good_id={$row['good_id']}'\">редактировать</div>";
                echo "</div>";
                echo "<p class='item-descriprion'>";
                echo $row['good_opisation'];
                echo "</p>";
                echo "<h3 class='item-price'>{$row['good_price']}р</h3>";
                echo "</div>";
                echo "</div>";
                
            }
        
        ?>
  </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="owl.carousel.min.js"></script>
  <script src="javascript.js"></script>
</body>
</html>