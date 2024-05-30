<?php

include 'config.php';
// Start the session
session_start();


// Fetch the top 5 highest-rated books based on the average rating from the comments table
$query = "
    SELECT b.*, AVG(c.rating) AS avg_rating
    FROM book b
    INNER JOIN comments c ON b.id = c.book_id
    GROUP BY b.id
    ORDER BY avg_rating DESC
    LIMIT 5
";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error: Could not execute the query: " . mysqli_error($conn);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOK STORE</title>
    <link rel="stylesheet" href="../projet_mémoire/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="../projet_mémoire/img/logo.png">
    

    <style>
        .book-containtes-row{
            margin-top: -5px;
        }
/* Container for the top-rated books section */
.container {
    display: flex;
    padding: -20px;

}

/* Container for each book */
.book {
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    overflow: hidden;
    width: 250px; 
    height: 600px;
    text-align: center;
    margin-left: -40px;
    margin-top: -50px;
}

/* Style for the book cover image */
.book img {
    width: 100%;
    height:400px;
    border-bottom: 1px solid #ddd;
}

/* Container for the book details */
.inf_book {
    padding: 1px;
}

/* Style for the book title */
.inf_book h4 {
    font-size: 1.2em;
    margin-bottom: 10px;
    color: #333;

}

/* Style for the average rating */
.inf_book .avg-rating {
    font-size: 1.1em;
    color: #FFD700; /* Gold color for the star */
    margin-left: 5px;
   
}

/* Style for the "View Details" link */
.inf_book .btn_view {
    display: inline-block;
    margin-top: 40px;
    padding: 8px 12px;
    background-color:#089da1;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.inf_book .btn_view:hover {
    background-color:#089da1;
}
.book-containtes-row h1 {
    font-size: 35px;
    margin-left: 100px;
    margin-top: 40px;
}

.book-containtes-row span {
    color: #089da1;
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

            <div class="social_icon">
                <a href="search.php" style="font-size: 20px;">🔎</a>
                <a href="logout.php"><i class='bx bx-log-out' style="font-size: 25px; color: black;"></i></a>
            </div>
        </nav>

        <div class="main">
            <div class="main_tag" id="defintion">
                <h1>WELCOME TO<br><span>BOOK STORE</span></h1>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda molestias atque laborum non fuga ex deserunt. Exercitationem velit ducimus praesentium, obcaecati hic voluptate id tenetur fuga illum quidem omnis? Rerum?
                </p>
                <a href="#about" class="main_btn">Learn More</a>
            </div>

            <div class="main_img">
                <img src="../projet_mémoire/img/table.png">
            </div>
        </div>
    </section>

    <div class="services">
        <h1>Special Service<span>BOOK STORE</span></h1><br><br>
        <div class="services_box">
            <div class="services_card">
                <i class='bx bxs-cloud-download'></i>
                <h3>Download files</h3>
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
            </div>

            <div class="services_card">
                <i class="fa-solid fa-headset"></i>
                <h3>24 x 7 Services</h3>
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
            </div>

            <div class="services_card">
                <i class="fa-solid fa-tag"></i>
                <h3>Open files</h3>
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
            </div>

            <div class="services_card">
                <i class="fa-solid fa-lock"></i>
                <h3>Secure</h3>
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
            </div>
        </div>
    </div>

    <br><br><br>

    <div class="book-containtes-row">
    <h1> Top 5 Highest <span>Rated Books</span></h1><br><br>
        <div class="container">
            
            <?php while ($book = mysqli_fetch_assoc($result)): ?>
                <div class="book">
                    <img src="admin/uploaded_img/<?php echo htmlspecialchars($book['cover'], ENT_QUOTES, 'UTF-8'); ?>" alt="Cover Image">
                    <div class="inf_book">
                        <h4><?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></h4>
                        <p><strong>Average Rating:</strong><span class="avg-rating"><?php echo number_format($book['avg_rating'], 2); ?> &#9733;</span></p>
                        <a href="page_review.php?id=<?php echo $book['id']; ?>" class="btn_view">View Details</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<br><br><br><br><br>

    <div class="book-containtes-row">
    <h1><span>Recommended Books </span>for User</h1><br><br>
        <?php 
        include 'Recommendation.php';
        ?>
        </div>
    </div>

    <!--About-->

    <div class="about" id="about">
        <div class="about_image">
            <img src="../projet_mémoire/img/about.png">
        </div>
        <div class="about_tag">
            <h1>About Us</h1>
            <p>
                Book Store is an online platform that provides an extensive library of books in digital format for free to everyone around the world. With Book Store you have access to all kinds of educational, motivational, and career books to keep you going in any area.
                Over the years, we have continued to provide valuable service to readers. Book Store has grown into a platform where self-publishing authors have the opportunity to introduce their work to our community.
            </p>
            <a href="#defintion" class="about_btn">Learn More</a>
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
                <a href="login.php">Login</a>
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

    

    <script src="../projet_mémoire/js/home.js"></script>
</body>

</html>
