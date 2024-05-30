<?php 
session_start(); // Start the session to track logged-in user

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login10.php'); // Redirect to login page if not logged in
    
    exit;
}

include 'config.php';


// Get the book ID from the query string
$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query_book = "SELECT * FROM book WHERE id = $book_id";
$result_book = mysqli_query($conn, $query_book);

if (mysqli_num_rows($result_book) == 1) {
    $book = mysqli_fetch_assoc($result_book);
} else {
    echo "Book not found!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review - <?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="../projet_mémoire/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="icon" href="../projet_mémoire/img/logo.png">
    <link rel="stylesheet" href="../projet_mémoire/css/home.css">
    <link rel="stylesheet" href="../projet_mémoire/css/page_review.css">
    <style>
        .container {
    display: flex;
}
.comments-container {
    margin-top: 20px;
    width: 250px;

}

.comment {
    margin-bottom: 15px;
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 5px;
    border:solid #089da1;
}

.comment p {
    margin: 0;
}

.comment strong {
    font-weight: bold;
    color: #333;
    margin-left: 80px;
}
.comment span {
    margin-left: 50px;
    color: #089da1;
}
.comment p:last-child {
    margin-top: 5px;
}

.comment:last-child {
    margin-bottom: 0;
}
.book-details a {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #089da1;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.book-details a:hover {
    background-color: #0056b3;
}
.submit-rating button {
    padding: 10px 20px;
    background-color: #089da1;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-left: 150px;
}
.stars {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 100px;
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
        <li><a href="book.php">Books</a></li>
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


<div class="container">
<div class="book-review-container">
    <div class="book-details">
        <img src="admin/uploaded_img/<?php echo htmlspecialchars($book['cover'], ENT_QUOTES, 'UTF-8'); ?>" alt="Cover Image" class="book_img">
        <h1><?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <?php 
        $author_query = mysqli_query($conn, "SELECT name_author FROM authors WHERE author_id = " . $book['author_id']);
        if (mysqli_num_rows($author_query) > 0) {
            $author_row = mysqli_fetch_assoc($author_query);
            $author_name = htmlspecialchars($author_row['name_author'], ENT_QUOTES, 'UTF-8');
        } else {
            $author_name = "Unknown Author";
        }
        $category_query = mysqli_query($conn, "SELECT name_category FROM categories WHERE categorie_id = " . $book['category_id']);
        if (mysqli_num_rows($category_query) > 0) {
            $category_row = mysqli_fetch_assoc($category_query);
            $category_name = htmlspecialchars($category_row['name_category'], ENT_QUOTES, 'UTF-8');
        } else {
            $category_name = "Unknown Category";
        }
        ?>
        <p><strong>Author:</strong> <?php echo $author_name; ?></p>
        <p><strong>Category:</strong> <?php echo $category_name; ?></p>
        <a href="register_opening.php?book_id=<?php echo $book['id']; ?>" >Open</a>
        <a href="register_download.php?book_id=<?php echo $book['id']; ?>" download>Download</a>

 </div>
</div>

        <div class="rating-container">
            <div class="stars" >
                <form action="submit_rating.php" method="post">
                    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5">&#9733;</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4">&#9733;</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3">&#9733;</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2">&#9733;</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1">&#9733;</label>
                    <div class="comment-box">
                        <textarea name="comment" rows="4" placeholder="Leave a comment..."></textarea>
                    </div>
                    <div class="submit-rating">
                        <button type="submit">Submit Rating</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="comments-container">
    <h2>Comments</h2>
<?php
// Fetch comments and ratings for the current book with user names
$query_comments = "SELECT comments.*, users.name AS user_name FROM comments 
                  INNER JOIN users ON comments.user_id = users.user_id 
                  WHERE comments.book_id = $book_id";
$result_comments = mysqli_query($conn, $query_comments);

if (mysqli_num_rows($result_comments) > 0) {
    while ($comment = mysqli_fetch_assoc($result_comments)) {
        $comment_text = htmlspecialchars($comment['comment'], ENT_QUOTES, 'UTF-8');
        $comment_user = htmlspecialchars($comment['user_name'], ENT_QUOTES, 'UTF-8');
        $avg_rating = $comment['rating'];
        $star_html = '';

        // Generate star icons based on average rating
        if ($avg_rating !== null) {
            $rounded_rating = round($avg_rating);
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rounded_rating) {
                    $star_html .= '<i class="fas fa-star"></i>'; // Use appropriate font awesome class
                } else {
                    $star_html .= '<i class="far fa-star"></i>'; // Use appropriate font awesome class
                }
            }
        } else {
            $star_html = "No rating";
        }

        ?>
        <div class="comment">
            <p><strong><?php echo $comment_user ?>:</strong> <br> <span><?php echo $star_html ?></span><br><br><?php echo $comment_text ?></p>
        </div>
        <?php
    }
} else {
    echo "<p>No comments yet.</p>";
}
?>

    <br><br><br><br><br>
</div>
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





   
</body>
</html>
