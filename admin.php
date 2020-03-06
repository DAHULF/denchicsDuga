<?php

    session_start();

    $problemsAtComing = false;

    if(isset($_POST['submit'])){
        
        require('data_base_confings.php');

        $connect = mysqli_connect(DATA_BASE_HOST, DATA_BASE_USER, DATA_BASE_PASSWORD, DATA_BASE_NAME) or $problemsAtComing = true;
        
        $usersLogin = mysqli_real_escape_string($connect, trim($_POST['login']));
        $usersPassword = mysqli_real_escape_string($connect, trim($_POST['password']));
        
        $query = "SELECT users_id, users_name FROM users WHERE user_login='$usersLogin' AND user_password=SHA('$usersPassword')";
        
        $result = mysqli_query($connect, $query) or $problemsAtComing = true;
        
        $row = mysqli_fetch_array($result);
        
        if(!$row){
            
            $problemsAtComing = true;
            
        }
        
        if(!$problemsAtComing){
            
            $_SESSION['admins_id'] = $row['users_id'];
            
            header('Location: adminPanel.php?'.SID);
            
        }
        
        mysqli_close($connect);
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/style.css">
  <title>вход</title>
</head>
<body class="admin-login">
  <div class="flex-block">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="adminLogin">
        
        <input type="text" name="login" class="login" placeholder="введите логин">
        <input type="password" name="password" class="password" placeholder="введите пароль">
        
        <input type="submit" class="btn" name="submit"/>
        
        <?php if($problemsAtComing) echo "<p class='error'>Не верный логин или пароль.</p>"; ?>
        
    </form>
  </div>
</body>
</html>