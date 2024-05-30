<?php
include('../admin/includs/header.php');

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'database') or die('Connection failed: ' . mysqli_connect_error());

$row = null; // Initialize $row to avoid undefined variable error
$errors = []; // Initialize error array
$success_msg = ''; // Initialize success message

if (isset($_GET['name_author'])) {
    $name_author = mysqli_real_escape_string($conn, $_GET['name_author']);
    $query = "SELECT * FROM `authors` WHERE `name_author` = '$name_author'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $errors[] = "Query failed: " . mysqli_error($conn);
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}

// Handle form submission for updating the author
if (isset($_POST['submit'])) {
    $name_author = mysqli_real_escape_string($conn, $_POST['name_author']);
    $author_id = mysqli_real_escape_string($conn, $_POST['author_id']);

    // Update the author details in the database
    $update_query = "UPDATE `authors` SET `name_author` = '$name_author' WHERE `author_id` = '$author_id'";

    if (mysqli_query($conn, $update_query)) {
        $success_msg = "Author updated successfully!";
    } else {
        $errors[] = "Error updating author: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Authors</title>
    <link rel="stylesheet" href="../admin/css/author_category.css">
</head>
<body>
<h2>Update Name of Authors</h2>
    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($success_msg)): ?>
        <div style="color: green;">
            <p><?php echo $success_msg; ?></p>
        </div>
    <?php endif; ?>
    <form method="post" class="add_author_category">
        <input type="hidden" name="author_id" value="<?php echo isset($row['author_id']) ? htmlspecialchars($row['author_id'], ENT_QUOTES) : ''; ?>">
        <label for="name">Update author:</label>
        <input type="text" id="name" name="name_author" required value="<?php echo isset($row['name_author']) ? htmlspecialchars($row['name_author'], ENT_QUOTES) : ''; ?>"><br><br>
        <button type="submit" name="submit">Save Author</button>
    </form>
</body>
</html>

<?php
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php');
?>