<?php
include 'config.php';
// Assuming you have already connected to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = $_POST['user_type'];
    
    // Perform validation (e.g., check if passwords match)
    if ($password != $cpassword) {
        // Handle password mismatch error
        echo "Passwords do not match";
        exit; // Exit script
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Determine which table to insert the data into based on user_type
    if ($user_type == 'admin') {
        $table_name = 'admin';
    } elseif ($user_type == 'user') {
        $table_name = 'users';
    } else {
        // Handle invalid user type error
        echo "Invalid user type";
        exit; // Exit script
    }

    // Insert user data into the appropriate table
    $sql = "INSERT INTO $table_name (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
    
    // Execute the SQL query
    if (mysqli_query($conn, $sql)) {
        echo "Registration successful";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOK STORE</title>
    <link rel="stylesheet" href="../projet_mémoire/css/sinup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

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



    <?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
 

    <div class="form-container" >

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" placeholder="enter your name" required class="box">
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="confirm your password" required class="box">
      <select name="user_type" class="box">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select>
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>
    
</div>
    <div class="img_sinup">
        <img src="../projet_mémoire/img/sinup_form.png" alt="">
    </div>

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
    <script src="public/js/sinup.js"></script>
</body>

</html>