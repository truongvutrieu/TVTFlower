<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'] ?? '';

if (!$user_id) {
    header('location:login.php');
    exit; // Ensure that no HTML code is outputted after the header command.
}

$message = [];

if (isset($_GET['delete'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
    exit;
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
    exit;
}

if (isset($_POST['update_quantity'])) {
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    $cart_quantity = mysqli_real_escape_string($conn, $_POST['cart_quantity']);
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'Cart quantity updated!';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php @include 'header.php'; ?>

    <section class="heading">
        <h3>Shopping Cart</h3>
        <p><a href="home.php">Home</a> / Cart </p>
    </section>

    <section class="shopping-cart">

        <h1 class="title">Products Added</h1>

        <div class="box-container">

            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            ?>
                    <div class="box">
                        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('Delete this from cart?');"></a>
                        <a href="view_page.php?pid=<?php echo $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
                        <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="image">
                        <div class="name"><?php echo $fetch_cart['name']; ?></div>
                        <div class="price">$<?php echo $fetch_cart['price']; ?>/-</div>
                        <form action="" method="post">
                            <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="cart_id">
                            <input type="number" min="1" value="<?php echo $fetch_cart['quantity']; ?>" name="cart_quantity" class="qty">
                            <input type="submit" value="Update" class="option-btn" name="update_quantity">
                        </form>
                        <div class="sub-total">Sub-total: <span>$<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span></div>
                    </div>
            <?php
                    $grand_total += $sub_total;
                }
            } else {
                echo '<p class="empty">Your cart is empty</p>';
            }
            ?>
        </div>

        <div class="more-btn">
            <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled' ?>" onclick="return confirm('Delete all from cart?');">Delete all</a>
        </div>

        <div class="cart-total">
            <p>Grand total: <span>$<?php echo $grand_total; ?>/-</span></p>
            <a href="shop.php" class="option-btn">Continue shopping</a>
            <a href="checkout.php" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled' ?>">Proceed to checkout</a>
        </div>

    </section>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>
