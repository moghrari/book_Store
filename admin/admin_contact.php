<?php
include('../admin/includs/header.php');
?>




<?php
// Assuming you have already connected to your database

// Fetch message information from the database
$conn = mysqli_connect('localhost', 'root', '', 'database') or die('connection failed');

$sql = "SELECT * FROM message";
$result = mysqli_query($conn, $sql);

// Check if there are any messages
if (mysqli_num_rows($result) > 0) {
    // Initialize an empty array to store message data
    $messages = array();

    // Iterate over each row of the result and append to the messages array
    while($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
} else {
    $messages = array(); // Empty array if no messages found
}
// If delete button is clicked
if (isset($_POST['delete'])) {
    $id = $_POST['message_id'];
    // Delete the book from the database
    $delete_query = "DELETE FROM message WHERE id = '$id'";
    if (mysqli_query($conn, $delete_query)) {
        $success_msg = "message deleted successfully!";
    } else {
        $errors[] = "Error deleting message: " . mysqli_error($conn);
    }
}
// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/css/admin_contact.css">
    <title>Administrator Page</title>
   
</head>
<body>
    <h1>Contact Page</h1>
    
    <?php foreach ($messages as $message): ?>
        <div class="message-container">
            <p><span>User Name:</span> <?php echo $message['name']; ?></p>
            <p><span>Email:   </span> <?php echo $message['email']; ?></p>
            <p><span>Message:</span><?php echo $message['message']; ?></p>
            <form action="" method="post">
                <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                <input type="submit" name="delete" value="Delete">
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>






<?php

include('../admin/includs/footer.php');
include('../admin/includs/scripts.php')
?>