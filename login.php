<?php

include 'config.php';
session_start(); // Start the session to manage user login state

// Assuming you have already connected to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user exists in the users table
    $user_query = "SELECT * FROM users WHERE email = '$email'";
    $user_result = mysqli_query($conn, $user_query);

    // Query to check if the user exists in the administrators table
    $admin_query = "SELECT * FROM admin WHERE email = '$email'";
    $admin_result = mysqli_query($conn, $admin_query);

    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $row = mysqli_fetch_assoc($user_result);
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, user is authenticated
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_type'] = 'user';
            header("Location:home.php"); // Redirect to user page
            exit();
        } else {
            echo "Incorrect password";
        }
    } elseif ($admin_result && mysqli_num_rows($admin_result) > 0) {
        $row = mysqli_fetch_assoc($admin_result);
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, user is authenticated
            $_SESSION['user_type'] = 'admin';
            header("location:admin/index.php"); // Redirect to admin page
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
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
    <title>BookStore</title>
    <link rel="stylesheet" href="../projet_mémoire/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <br><br><br><br><br>
    <?php
    if (isset ($message)) {
        foreach ($message as $message) {
            echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }
    ?>

    <div class="form-container">

        <form action="" method="post">
            <h3>login now</h3>
            <input type="email" name="email" placeholder="enter your email" required class="box">
            <input type="password" name="password" placeholder="enter your password" required class="box">
            <input type="submit" name="submit" value="login now" class="btn">
            <p>don't have an account? <a href="sinup.php">register now</a></p>
        </form>

    </div>
    <div class="img_login" style="margin-left :300px;">
        <img src="../projet_mémoire/img/login.png" alt="">
    </div>
    <br><br><br><br><br>
    <footer>
        <div class="footer_main">

            <div class="tag">
                <h1>BOOK STORE</h1>
                <p>
                    Book Store was established in 2024 with the vision to provide an extensive library of books in
                    digital format for free on the Internet.
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