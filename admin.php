<?php

    session_start();

    $problemsAtComing = false;

    if(isset($_POST['submit'])){
        
        require('data_base_confings.php');
        
        $connect = mysqli_connect(DATA_BASE_HOST, DATA_BASE_USER_NAME, DATA_BASE_USER_PASSWORD, DATA_BASE_NAME);
        
        $usersLogin = mysqli_real_escape_string($connect, trim($_POST['login']));
        $usersPassword = mysqli_real_escape_string($connect, trim($_POST['password']));
        
        $query = "SELECT users_id, first_name, degree_of_access FROM users WHERE user_login='$usersLogin' AND user_password=SHA('$usersPassword')";
        
        $result = mysqli_query($connect, $query) or $problemsAtComing = true;
        
        $row = mysqli_fetch_array($result);
        
        if(!$row){
            
            $problemsAtComing = true;
            
        }
        
        if(!$problemsAtComing){
            
            $_SESSION['admins_login'] = $row['users_id'];
            
            header('Location: index.php?'.SID);
            
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
  <title>Document</title>
</head>
<body class="admin-login">
  <div class="flex-block">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="adminLogin">
        
        <input type="text" name="login" class="login" placeholder="введите логин">
        <input type="password" name="password" class="password" placeholder="введите пароль">
        
        <input type="submit" class="btn" name="submit"/>
        
    </form>
  </div>
</body>
</html>