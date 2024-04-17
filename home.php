<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
   exit(); // Added exit to prevent further execution
}

$message = array(); // Initialize message array

if(isset($_POST['add_to_wishlist'])){

   // Validate and sanitize input data
   $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
   $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
   $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
   $product_image = mysqli_real_escape_string($conn, $_POST['product_image']);
   
   // Check if the product already exists in the wishlist
   $check_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('Query failed');

   // Check if the product already exists in the cart
   $check_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('Query failed');

   if(mysqli_num_rows($check_wishlist) > 0){
       $message[] = 'Already added to wishlist';
   } elseif(mysqli_num_rows($check_cart) > 0) {
       $message[] = 'Already added to cart';
   } else {
       // Insert the product into the wishlist
       mysqli_query($conn, "INSERT INTO `wishlist` (user_id, pid, name, price, image) VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('Query failed');
       $message[] = 'Product added to wishlist';
   }

}

if(isset($_POST['add_to_cart'])){

   // Validate and sanitize input data
   $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
   $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
   $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
   $product_image = mysqli_real_escape_string($conn, $_POST['product_image']);
   $product_quantity = mysqli_real_escape_string($conn, $_POST['product_quantity']);

   // Check if the product already exists in the cart
   $check_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('Query failed');

   if(mysqli_num_rows($check_cart) > 0){
       $message[] = 'Already added to cart';
   } else {
       // Delete the product from the wishlist if it exists there
       $check_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('Query failed');

       if(mysqli_num_rows($check_wishlist) > 0){
           mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('Query failed');
       }

       // Insert the product into the cart
       mysqli_query($conn, "INSERT INTO `cart` (user_id, pid, name, price, quantity, image) VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('Query failed');
       $message[] = 'Product added to cart';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>New collections</h3>
      <p>We are continuously assisting customers by delivering fresh flowers to celebrate special moments. Our mission is to provide value-for-money to every customer through premium products, services, innovation, technology, and a customer-first approach at all times.</p>
      <a href="about.php" class="btn">Discover more</a>
   </div>

</section>

<section class="products">

   <h1 class="title">Latest products</h1>

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('Query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST" class="box">
         <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <input type="number" name="product_quantity" value="1" min="0" class="qty">
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <input type="submit" value="Add to wishlist" name="add_to_wishlist" class="option-btn">
         <input type="submit" value="Add to cart" name="add_to_cart" class="btn">
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No products added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="shop.php" class="option-btn">Load more</a>
   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Have any questions?</h3>
      <p>Is there a preferred method for us to contact you? Please submit your questions here, and we will strive to provide you with the most prompt and helpful responses possible.</p>
      <a href="contact.php" class="btn">Contact us</a>
   </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
