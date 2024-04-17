<?php

include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
   header('location: login.php');
   exit(); // Kết thúc kịch bản sau khi chuyển hướng
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   $name = $_POST['name'];
   $email = $_POST['email'];
   $old_pass = $_POST['old_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['cpass'];

   // Kiểm tra và xử lý cập nhật thông tin người dùng
   $stmt = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $stmt->bind_param("ssi", $name, $email, $user_id);
   $stmt->execute();
   $stmt->close();

   // Kiểm tra và xử lý cập nhật mật khẩu
   if (!empty($old_pass) && !empty($new_pass) && !empty($confirm_pass)) {
      $stmt = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $stored_password = $row['password'];
      $stmt->close();

      if (sha1($old_pass) === $stored_password && $new_pass === $confirm_pass) {
         $hashed_password = sha1($new_pass);
         $stmt = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $stmt->bind_param("si", $hashed_password, $user_id);
         $stmt->execute();
         $stmt->close();
      }
   }

   // Chuyển hướng người dùng sau khi cập nhật
   header('Location: profile.php');
   exit(); // Kết thúc kịch bản sau khi chuyển hướng
}

// Truy vấn thông tin người dùng để hiển thị trong biểu mẫu
$stmt = $conn->prepare("SELECT name, email FROM `users` WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$fetch_profile = $result->fetch_assoc();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <section class="form-container">

      <form action="" method="post">
         <h3>Profile</h3>
         <input type="text" name="name" required placeholder="Enter your username" maxlength="20" class="box" value="<?= $fetch_profile["name"]; ?>">
         <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="box" value="<?= $fetch_profile["email"]; ?>">
         <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="20" class="box">
         <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="20" class="box">
         <input type="password" name="cpass" placeholder="Confirm your new password" maxlength="20" class="box">
         <input type="submit" value="Update now" class="btn" name="submit">
      </form>

   </section>

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>
