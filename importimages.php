<?php

    //admin check

    session_start();

    $data_base_problem = false;

    require("data_base_confings.php");

    $connect = mysqli_connect(DATA_BASE_HOST, DATA_BASE_USER, DATA_BASE_PASSWORD, DATA_BASE_NAME) or $data_base_problem = true;

    if(empty($_SESSION['admins_id'])){
        
        header("Location: admin.php?hello=1");
        
    }else{
        
        $query = "SELECT users_name FROM users WHERE users_id={$_SESSION['admins_id']}";
        
        $result = mysqli_query($connect, $query);
        
        if(!$row = mysqli_fetch_array($result)){
            
            header("Location: admin.php?hello=2");
            
        }
        
    }

    //backend begin
    if(empty($_SESSION['good_id'])){
        
        $query = "SELECT good_id FROM goods_data ORDER BY good_id DESC LIMIT 1";
                    
        $result = mysqli_query($connect, $query) or $data_base_problem = true;
        $row = mysqli_fetch_array($result);
        $_SESSION['good_id'] = $row['good_id'];
        
    }

    //problem variables
    $download_problem = false;
    $type_problem = false;
    $size_problem = false;
    $image_name_length_problem = false;

    //option variables
    $image_num = 1;
    
    if(empty($_SESSION['image_num'])){
        
        $_SESSION['image_num'] = 1;
        
    }else{
        
        $image_num = $_SESSION['image_num'];
        
    }

    if(empty($_SESSION['good_id'])){
        
        header('Location: adminPanel.php');
        
    }

    if($image_num > 6){
        
        $_SESSION['image_num'] = null;
        $_SESSION['good_id'] = null;
        
        header("Location: adminPanel.php");
        
    }

    //submit block
    if(isset($_POST['submit'])){
        
        $connect = mysqli_connect(DATA_BASE_HOST, DATA_BASE_USER, DATA_BASE_PASSWORD, DATA_BASE_NAME) or $data_base_problem = true;
        
        if($_FILES['goodsImg']['error']){
            
            @unlink($_FILES['goodsImg']['tmp_name']);
            
            $download_problem = true;
            
        }
        
        if(($_FILES['goodsImg']['type'] != 'image/gif') && ($_FILES['goodsImg']['type'] != 'image/jpeg') && ($_FILES['goodsImg']['type'] != 'image/pjpeg') && ($_FILES['goodsImg']['type'] != 'image/png')){
            
            @unlink($_FILES['goodsImg']['tmp_name']);
            $type_problem = true;
            
        }
        
        if($_FILES['goodsImg']['size'] > 1283000){
            
            @unlink($_FILES['goodsImg']['tmp_name']);
            
            $size_problem = true;
            
        }
        
        if(!$data_base_problem && !$download_problem && !$type_problem && !$size_problem){
            
            $image_way = "img/{$_FILES['goodsImg']['name']}";
            move_uploaded_file($_FILES['goodsImg']['tmp_name'], $image_way);
            
            if(strlen($image_way) > 50){
            
                $image_name_length_problem = true;
                @unlink($image_way);
                
            }else{
                
                $query = "INSERT INTO goods_images(goods_id, image_way) VALUES('{$_SESSION['good_id']}', '$image_way')";
                
                $result = mysqli_query($connect, $query) or $data_base_problem = true;
                
                $_SESSION['image_num'] = $image_num + 1;
            
                if($data_base_problem){
                    
                    @unlink($image_way);
                    $_SESSION['image_num'] = $image_num - 1;
                    
                }
                
            }
            
        }
        
    }

    if(isset($_POST['back'])){
        
        $_SESSION['image_num'] = null;
        $_SESSION['good_id'] = null;
        
        header("Location: adminPanel.php");
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>импорт картинок</title>
</head>
<body>
    <div id="drop-area">
      <form enctype="multipart/form-data" class="my-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <p>картинка должна быть 4к3 что бы не растягивалась</p>
        <p><?php echo $image_num; ?> из 6</p>
        <input type="file" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)" name="goodsImg">
        <label class="button" for="fileElem">импортировать картинку либо бросьте мышкой сюда</label>
        <input type="submit" name="submit" value="Продолжить"/>
        <?php if($image_num > 2){ echo '<input type="submit" name="back" value="Закончить"/>'; } ?>
      </form>
        <?php
        
            if($data_base_problem) echo "Ошибка добавления изображения в базу данных";
            if($download_problem) echo "Ошибка при загрузки изображения на сервер";
            if($type_problem) echo "Ошибка типа загружаемого файла";
            if($size_problem) echo "Файл слишком большой";
            if($image_name_length_problem) echo "Название файла слишком длинное";
            if($data_base_problem || $download_problem || $type_problem || $size_problem || $image_name_length_problem) echo "</br>";
        
        ?>
        <progress id="progress-bar" max=100 value=0></progress>
      <div id="gallery" /></div>
    </div>
    <style>
body {
  font-family: sans-serif;
}
a {
  color: #369;
}
.note {
  width: 500px;
  margin: 50px auto;
  font-size: 1.1em;
  color: #333;
  text-align: justify;
}
#drop-area {
  border: 2px solid #ccc;
  border-radius: 20px;
  width: 480px;
  margin: 50px auto;
  padding: 20px;
}
#drop-area.highlight {
  border-color: purple;
}
p {
  margin-top: 0;
}
.my-form {
  margin-bottom: 10px;
}
#gallery {
  margin-top: 10px;
}
#gallery img {
  width: 150px;
  margin-bottom: 10px;
  margin-right: 10px;
  vertical-align: middle;
}
.button {
  display: inline-block;
  padding: 10px;
  background: #ccc;
  cursor: pointer;
  border-radius: 5px;
  border: 1px solid #ccc;
}
.button:hover {
  background: #ddd;
}
#fileElem {
  display: none;
}
    </style>
    <script src="draganddrop.js"></script>
</body>
</html>