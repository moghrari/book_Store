<?php 
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOK STORE</title>
    <link rel="stylesheet" href="../projet_mémoire/css/blog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="../projet_mémoire/img/logo.png">


</head>
<body>
    <section>
        <nav>

            <div class="logo">
                <img src="../projet_mémoire/img/logo1.png">
            </div>

            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="book.php">Books</a></li>
                <li><a href="Blog.php">Blog</a></li>
                <li><a href="Contact.php">Contact</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>

            <div class="social_icon">
                <a href="search.php" style="font-size :22px">🔎</a>
                <a href="logout.php"><i class='bx bx-log-out' style="font-size: 25px; color: black;"></i></a>
            </div>

        </nav>
</section>
   
<section class="blog">

   <h1 class="title">latest blogs</h1>

   <div class="blog_card" >

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `blog`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="blog_img" src="admin/uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" ><br><br>
      <div class="blog_tag_h"><?php echo $fetch_products['name']; ?></div><br>
      <div class="blog_tag_p"><?php echo $fetch_products['text']; ?></div><br>
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_text" value="<?php echo $fetch_products['text']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <div class="blog_icon">
        <i class="fa-solid fa-calendar-days"></i>
        <i class="fa-solid fa-heart"></i>
    </div>
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
    
   </div>

</section>
    <footer>
        <div class="footer_main">

            <div class="tag">
                <h1>BOOK STORE</h1>
                <p>
                    Book Store was established in 2024 with the vision to provide an extensive library of books in digital format for free on the Internet.
                </p>

            </div>

            <div class="tag">
                <h1>Quick Link</h1>
                <a href="home.php">Home</a>
                <a href="#about">About</a>
                <a href="book.php">Books</a>
                <a href="blog.php">Blog</a>
                <a href="login.php">login</a>

            </div>

            <div class="tag">
                <h1>Contact Info</h1>
                <a href="#"><i class="fa-solid fa-phone"></i>+94 12 345 6789</a>
                <a href="#"><i class="fa-solid fa-phone"></i>+94 32 444 699</a>
                <a href="#"><i class="fa-solid fa-envelope"></i>bookstore123@gmail.com</a>

            </div>

            <div class="tag">
                <h1>Follow Us</h1>
                <div class="social_link">
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-linkedin-in"></i>
                </div>

            </div>


        </div>

    </footer>
</body>