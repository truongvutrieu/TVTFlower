<?php

include 'config.php';
session_start();

$message = array();

if(isset($_POST['submit'])) {
    // Validate and sanitize user input
    $filter_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, $filter_pass);

    // Check if email and password are provided
    if(empty($email) || empty($pass)) {
        $message[] = 'Email and password are required!';
    } else {
        // Encrypt the password securely
        $encrypted_pass = md5($pass);

        // Prepare and execute the SQL query
        $select_users = mysqli_prepare($conn, "SELECT * FROM `users` WHERE email = ? AND password = ?");
        mysqli_stmt_bind_param($select_users, "ss", $email, $encrypted_pass);
        mysqli_stmt_execute($select_users);
        mysqli_stmt_store_result($select_users);

        // Check if user exists
        if(mysqli_stmt_num_rows($select_users) > 0) {
            mysqli_stmt_bind_result($select_users, $id, $name, $email, $password, $user_type);
            mysqli_stmt_fetch($select_users);

            // Set session variables based on user type
            if($user_type == 'admin') {
                $_SESSION['admin_name'] = $name;
                $_SESSION['admin_email'] = $email;
                $_SESSION['admin_id'] = $id;
                header('Location: admin_page.php');
                exit();
            } elseif($user_type == 'user') {
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_id'] = $id;
                header('Location: home.php');
                exit();
            }
        } else {
            $message[] = 'Incorrect email or password!';
        }
        mysqli_stmt_close($select_users);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(!empty($message)) {
    foreach($message as $msg) {
        echo '
        <div class="message">
           <span>'.$msg.'</span>
           <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>
   
<section class="form-container">
   <form action="" method="post">
      <h3>Login now</h3>
      <input type="email" name="email" class="box" placeholder="Enter your email" required>
      <input type="password" name="pass" class="box" placeholder="Enter your password" required>
      <input type="submit" class="btn" name="submit" value="Login now">
      <p>Don't have an account? <a href="register.php">Register now</a></p>
   </form>
</section>

</body>
</html>
