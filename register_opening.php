<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login10.php');
    exit;
}

if (isset($_GET['book_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = intval($_GET['book_id']);
    
    // Insert into book_opened table
    $query = "INSERT INTO books_opened (user_id, book_id) VALUES (?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ii", $user_id, $book_id);
        if (!$stmt->execute()) {
            echo "Error: Could not execute the query: " . $conn->error;
            exit;
        }
        $stmt->close();
    } else {
        echo "Error: Could not prepare the query: " . $conn->error;
        exit;
    }

    // Fetch the book file path
    $query = "SELECT file FROM book WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $stmt->bind_result($file);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Error: Could not prepare the query: " . $conn->error;
        exit;
    }

    // Redirect to the file
    header('Location: admin/uploaded_img/' . urlencode($file));
    exit;
} else {
    echo "Error: Book ID not specified.";
    exit;
}
?>
