<?php

include 'config.php';

session_start();

if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit(); // End the script after redirection
}

$admin_id = $_SESSION['admin_id'];

// Query admin information to display in the form
$stmt = $conn->prepare("SELECT name, password FROM `users` WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$fetch_profile = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   // Update admin's name
   $stmt = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
   $stmt->bind_param("si", $name, $admin_id);
   $stmt->execute();
   $stmt->close();

   // Handling password update
   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $old_pass = sha1($_POST['old_pass']);
   $new_pass = sha1($_POST['new_pass']);
   $confirm_pass = sha1($_POST['confirm_pass']);

   if ($old_pass === $empty_pass) {
      $message[] = 'Please enter old password!';
   } elseif ($old_pass !== $fetch_profile['password']) {
      $message[] = 'Old password does not match!';
   } elseif ($new_pass !== $confirm_pass) {
      $message[] = 'Confirm password does not match!';
   } else {
      if ($new_pass !== $empty_pass) {
         // Update new password
         $stmt = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
         $stmt->bind_param("si", $new_pass, $admin_id);
         $stmt->execute();
         $stmt->close();
         $message[] = 'Password updated successfully!';
      } else {
         $message[] = 'Please enter a new password!';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
   <style>
      .form-container {
         display: flex;
         flex-direction: column;
         align-items: center;
         margin-top: 20px; /* Thêm khoảng cách từ header xuống form */
      }

      .form-container form {
         width: 100%;
         max-width: 400px;
         padding: 20px;
         border: 1px solid #ccc;
         border-radius: 5px;
         background-color: #fff;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .form-container h3 {
         margin-bottom: 20px;
         text-align: center;
         font-size: 24px; /* Chỉnh kích thước chữ "Update Profile" thành 24px */
      }

      .box {
         width: 100%;
         margin-bottom: 15px;
         padding: 10px;
         border: 1px solid #ccc;
         border-radius: 5px;
         box-sizing: border-box;
         font-size: 16px;
      }

      .btn {
         width: 50%;
         padding: 12px;
         border: none;
         border-radius: 5px;
         background-color: #e84393;
         color: #fff;
         cursor: pointer;
         font-size: 16px;
      }

      .btn:hover {
         background-color: var(--black);;
      }
   </style>
</head>

<body>

   <?php include 'admin_header.php'; ?>

   <section class="form-container">

      <form action="" method="post">
         <h3>Profile</h3>
         <input type="text" name="name" required placeholder="Enter your username" maxlength="20" class="box"
            value="<?= $fetch_profile['name']; ?>">
         <input type="password" name="old_pass" placeholder="Enter old password" maxlength="20" class="box">
         <input type="password" name="new_pass" placeholder="Enter new password" maxlength="20" class="box">
         <input type="password" name="confirm_pass" placeholder="Confirm new password" maxlength="20" class="box">
         <input type="submit" value="Update now" class="btn" name="submit">
      </form>

   </section>

   <script src="js/admin_script.js"></script>

</body>

</html>


