<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>about us</h3>
    <p> <a href="home.php">Home</a> / About </p>
</section>

<section class="about">

    <div class="flex">

        <div class="image">
            <img src="images/about-img-1.png" alt="">
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>For loved ones, we offer affordable and diverse options, including fresh flowers and gift combos. Enjoy express flower delivery with a quick response and improved customer service. Our company sources products directly from manufacturers, ensuring freshness and eliminating costly intermediaries. This cost-effective approach is reflected in transparent pricing, allowing for savings calculations compared to market prices.</p>
            <a href="shop.php" class="btn">shop now</a>
        </div>

    </div>

    <div class="flex">

        <div class="content">
            <h3>what we provide?</h3>
            <p>Our focus is to ensure you have stress-free and delightful experiences while exploring the best options for flowers on our portal. Our main goal is to provide you with high-quality products, including fresh flowers, with a guarantee of satisfaction. We are committed to helping customers find suitable flowers efficiently and ensuring timely delivery, making it our responsibility.</p>
            <a href="contact.php" class="btn">contact us</a>
        </div>

        <div class="image">
            <img src="images/about-img-2.jpg" alt="">
        </div>

    </div>

    <div class="flex">

        <div class="image">
            <img src="images/about-img-3.jpg" alt="">
        </div>

        <div class="content">
            <h3>who we are?</h3>
            <p>Originating from a small flower shop in Can Tho, this website evolved to offer an efficient online flower-selling experience. Launched in 2024, it follows the principles of 'Fresh, Fast, and Fair.' The goal is to provide the best quality flowers at affordable prices for customers in the city, aiming to serve the local community effectively.</p>
            <a href="#reviews" class="btn">clients reviews</a>
        </div>

    </div>

</section>

<section class="reviews" id="reviews">

    <h1 class="title">client's reviews</h1>

    <div class="box-container">

        <div class="box">
            <img src="images/user.png" alt="">
            <p>To be honest, the order I placed for the red rose bouquet is even more beautiful than pictured! Extremely satisfied with the experience! Grateful for the exquisite flowers... My family members are delighted, and those were truly fresh and stunning roses. Thank you!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Truong Vu Trieu</h3>
        </div>

        <div class="box">
            <img src="images/user.png" alt="">
            <p>I ordered flowers for my daughter's special birthday, and the flowers delivered by the website's team were exactly as shown. It was timely, and my requests were met effortlessly. Will definitely order here again! Grateful for the excellent service.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Truong Vu Trieu</h3>
        </div>

        <div class="box">
            <img src="images/user.png" alt="">
            <p>Though hesitant when placing my order, it surpassed expectations. The tulip flowers were fresh and beautiful, providing reassurance. Looking forward to continued excellent service. Additionally, the recent order boasted swift delivery, enhancing the overall experience</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Truong Vu Trieu</h3>
        </div>

        <div class="box">
            <img src="images/user.png" alt="">
            <p>I recently ordered flowers for my loved one, and the experience was fantastic! The flowers were fresh, and the delivery was prompt. The customer service exceeded my expectations. Highly recommend for expressing love and care through beautiful blooms!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Truong Vu Trieu</h3>
        </div>

        <div class="box">
            <img src="images/user.png" alt="">
            <p>Today, flowers rescued my stressful day. After requesting the flower shop's contact for delivery and expressing my wish for evening delivery before 5 PM, my request was declined. Only this website fulfilled my request, making today's event extra special.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Truong Vu Trieu</h3>
        </div>

        <div class="box">
            <img src="images/user.png" alt="">
            <p>Great service, fresh flowers, and beautiful arrangement. Recently bought flowers from this website and I'm highly satisfied! Especially impressed by the quick response of customer service and their flexibility in arranging delivery time.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Truong Vu Trieu</h3>
        </div>

    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>