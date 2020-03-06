<?php

    session_start();

    require('data_base_confings.php');

    $connect = mysqli_connect(DATA_BASE_HOST, DATA_BASE_USER, DATA_BASE_PASSWORD, DATA_BASE_NAME);

    //admin check
    if(empty($_SESSION['admins_id'])){
        
        header("Location: admin.php");
        
    }else{
        
        $query = "SELECT users_name FROM users WHERE users_id={$_SESSION['admins_id']}";
        
        $result = mysqli_query($connect, $query);
        
        if(!$row = mysqli_fetch_array($result)){
            
            header("Location: admin.php");
            
        }
        
    }

    //problem variables
    $delete_problems = false;
    $delete_is_accept = false;

    //options variables
    if(!empty($_GET['good_id'])){
        
        $_SESSION['good_id'] = $_GET['good_id'];
        
    }

    $good_id;

    if(empty($_SESSION['good_id'])){
        
        header('Location: adminPanel.php');
        
    }else{
        
        $good_id = $_SESSION['good_id'];
        
    }

    //delete good
    if(isset($_POST['submit'])){
        
        $delete_is_accept = true;
        
        $query = "SELECT image_way FROM goods_images WHERE goods_id={$good_id}";
    
        $result = mysqli_query($connect, $query) or $delete_problems = true;
    
        while($row = mysqli_fetch_array($result)){
            
            @unlink($row['image_way']);
            
        }
    
        $query = "DELETE FROM goods_images WHERE goods_id={$good_id}";
    
        $result = mysqli_query($connect, $query) or $delete_problems = true;
    
        if(!$delete_problems){
            
            $query = "DELETE FROM goods_data WHERE good_id={$good_id}";
            
            $result = mysqli_query($connect, $query) or $delete_problems = true;
            
            $_SESSION['good_id'] = null;
            
        }
        
    }

    //report about delete

    if($delete_problems && $delete_is_accept) echo "Ошибка удаления товара";
    else if($delete_is_accept) echo "Товар успешно удалён";

?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

    <p>Вы уверены что хотите удалить товар ?</p>
    <input type="submit" name="submit" value="удалить"/>
    
</form>