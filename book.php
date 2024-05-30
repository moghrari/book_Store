<?php 
session_start(); // Start the session to track logged-in user

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login10.php'); // Redirect to login page if not logged in
    exit;
}

include 'config.php';

$query_books = "SELECT * FROM book";
$result_books = mysqli_query($conn, $query_books);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOK STORE</title>
    <link rel="stylesheet" href="../projet_mémoire/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="icon" href="../projet_mémoire/img/logo.png">
    <link rel="stylesheet" href="../projet_mémoire/css/home.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

       

        .book-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            margin-top: -650px;
        }

        .book {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 10px;
            padding: 10px;
            text-align: center;
            width: 280px;
            height: 430px;
        }

        .book img.book_img {
            margin-bottom: 10px;
            width: 180px;
            height: 270px;
        }

        .book h4 {
            font-size: 18px;
            margin: 10px 0;
        }

        .btn-link {
            background-color: #089da1;
            border: none;
            border-radius: 3px;
            color: white;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            margin: 10px 0;
            padding: 10px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-link:hover {
            background-color: #067d7d;
        }

        .span {
            margin-right: 5px;
        }

        ion-icon {
            vertical-align: middle;
        }
    </style>
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
        <li><a href="page_book.php">Books</a></li>
        <li><a href="Blog.php">Blog</a></li>
        <li><a href="Contact.php">Contact</a></li>
        <li><a href="login.php">Login</a></li>

    </ul>

    <div class="social_icon" >
        <a href="search.php" style="font-size :20px">🔎</a>
        <a href="logout.php"><i class='bx bx-log-out' style="font-size :25px; color: black;"></i></a>
    </div>

</nav>

</section>
<?php
// Check if there are any books
if (mysqli_num_rows($result_books) > 0) {
    echo "<div class='book-container'>";
    while ($row = mysqli_fetch_assoc($result_books)) {
        echo "<div class='book'>";
        echo "<img src='admin/uploaded_img/" . htmlspecialchars($row['cover'], ENT_QUOTES, 'UTF-8') . "' alt='Cover Image' class='book_img'><br>";
        echo "<h4>" . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . "</h4><br>";
        echo "<a href='page_review.php?id=" . urlencode($row['id']) . "' class='btn-link'>
                <span class='span'>Review</span>
            </a>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<h2>No books found!</h2>";
}
?>
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
