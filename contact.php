<?php

include 'config.php';



if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND message = '$msg'") or die('query failed');

   if(mysqli_num_rows($select_message) > 0){
      $message[] = 'message sent already!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(name, email, message) VALUES('$name', '$email', '$msg')") or die('query failed');
      $message[] = 'message sent successfully!';
   }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOK STORE</title>
    <link rel="stylesheet" href="../projet_mémoire/css/contact.css">
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


    
    <section class="contact">

      <form action="" method="post">
          <h3>say something!</h3>
          <input type="text" name="name" required placeholder="enter your name" class="box">
          <input type="email" name="email" required placeholder="enter your email" class="box">
          <textarea name="message" class="box" placeholder="enter your message" id="" cols="30" rows="10"></textarea>
          <input type="submit" value="send message" name="send" class="btn">
      </form>

    </section>
    <div class="img_contact">
      <img src="../projet_mémoire/img/contact.png" alt="" style="margin-left: 150px;">
    </div>
    <br><br><br><br><br>

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

</html>