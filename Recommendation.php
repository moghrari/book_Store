<?php
// Database connection
include 'config.php';

// Function to get all ratings from the comments table
function getRatings($conn) {
    $ratings = array();
    $result = mysqli_query($conn, "SELECT * FROM comments");
    while ($row = mysqli_fetch_assoc($result)) {
        $ratings[$row['user_id']][$row['book_id']] = $row['rating'];
    }
    return $ratings;
}

// Function to calculate similarity score between two users
function similarityScore($ratings, $user1, $user2) {
    $commonBooks = array();
    foreach ($ratings[$user1] as $book => $rating) {
        if (isset($ratings[$user2][$book])) {
            $commonBooks[$book] = 1;
        }
    }

    if (count($commonBooks) == 0) return 0;

    $sumOfSquares = 0;
    foreach ($commonBooks as $book => $v) {
        $sumOfSquares += pow($ratings[$user1][$book] - $ratings[$user2][$book], 2);
    }

    return 1 / (1 + sqrt($sumOfSquares));
}

// Function to get recommendations for a user
function getRecommendations($conn, $user) {
    $ratings = getRatings($conn);
    $totals = array();
    $simSums = array();

    foreach ($ratings as $otherUser => $otherRatings) {
        if ($otherUser != $user) {
            $sim = similarityScore($ratings, $user, $otherUser);

            if ($sim > 0) {
                foreach ($otherRatings as $book => $rating) {
                    if (!isset($ratings[$user][$book])) {
                        if (!isset($totals[$book])) {
                            $totals[$book] = 0;
                        }
                        $totals[$book] += $rating * $sim;

                        if (!isset($simSums[$book])) {
                            $simSums[$book] = 0;
                        }
                        $simSums[$book] += $sim;
                    }
                }
            }
        }
    }

    $rankings = array();
    foreach ($totals as $book => $total) {
        $rankings[$book] = $total / $simSums[$book];
    }

    arsort($rankings);
    return $rankings;
}

// Function to find the user who has downloaded the most books
function getTopDownloader($conn) {
    $result = mysqli_query($conn, "SELECT user_id, COUNT(*) AS download_count FROM downloads GROUP BY user_id ORDER BY download_count DESC LIMIT 1");
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['user_id'];
    }
    return null;
}

// Find the top downloader
$userId = getTopDownloader($conn);

// If a top downloader is found, get and display recommendations for that user
if ($userId) {
    $recommendations = getRecommendations($conn, $userId);
    echo "<ul>";
    foreach ($recommendations as $bookId => $score) {
        $result = mysqli_query($conn, "SELECT * FROM book WHERE id = $bookId");
        if ($book = mysqli_fetch_assoc($result)) {
            // Fetch author name
            $author_query = mysqli_query($conn, "SELECT name_author FROM authors WHERE author_id = " . $book['author_id']);
            if (mysqli_num_rows($author_query) > 0) {
                $author_row = mysqli_fetch_assoc($author_query);
                $author_name = htmlspecialchars($author_row['name_author'], ENT_QUOTES, 'UTF-8');
            } else {
                $author_name = "Unknown Author";
            }

            // Fetch category name
            $category_query = mysqli_query($conn, "SELECT name_category FROM categories WHERE categorie_id = " . $book['category_id']);
            if (mysqli_num_rows($category_query) > 0) {
                $category_row = mysqli_fetch_assoc($category_query);
                $category_name = htmlspecialchars($category_row['name_category'], ENT_QUOTES, 'UTF-8');
            } else {
                $category_name = "Unknown Category";
            }

            echo "<div class ='container_reco'>";
            echo "<img src='admin/uploaded_img/" . htmlspecialchars($book['cover'], ENT_QUOTES, 'UTF-8') . "' alt='Cover Image' class='book_img'><br>";
            echo "<li>" . htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ."<br>". " (Score: " . round($score, 2) . ")</li>";    
            echo "<a href='page_review.php?id=" . $book['id'] . "' class='btn_view'>View Details</a>";
            echo "</div>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>No downloads found in the database.</p>";
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
.container_reco {
    display: inline-block;
    width: 200px; /* Adjust as needed */
    margin: 10px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    overflow: hidden;
    width: 250px; 
    height: 550px;
    text-align: center;
    margin-left: 160px;
    margin-top: 10px;

}

.book_img {
    width: 100%;
    height:400px;
    border-bottom: 1px solid #ddd;
}

.btn_view {
    display: inline-block;
    margin-top: 40px;
    padding: 8px 12px;
    background-color:#089da1;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

    </style>
</head>
<body>
</body>
</html>
