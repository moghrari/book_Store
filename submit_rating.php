<?php
session_start();
include 'config.php';

// Assuming the user has already been authenticated before accessing this page

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure $user_id is obtained from the session after login
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    } else {
        echo "Error: User ID not found in session.";
        exit();
    }

    $book_id = intval($_POST['book_id']);
    $rating = intval($_POST['rating']);
    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');

    // Prepare and execute the SQL query to insert comment
    $query = "INSERT INTO comments (user_id, book_id, rating, comment) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("iiis", $user_id, $book_id, $rating, $comment);
        if ($stmt->execute()) {
            // Redirect to review page after successful insertion
            header('Location: page_review.php?id=' . $book_id);
            exit();
        } else {
            echo "Error: Could not execute the query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Could not prepare the query: " . $conn->error;
    }
} 

$conn->close(); // Close database connection
?>
