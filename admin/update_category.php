<?php
include('../admin/includs/header.php');

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'database') or die('Connection failed: ' . mysqli_connect_error());

$row = null; // Initialize $row to avoid undefined variable error
$errors = []; // Initialize error array
$success_msg = ''; // Initialize success message

if (isset($_GET['name_category'])) {
    $name_category = mysqli_real_escape_string($conn, $_GET['name_category']);
    $query = "SELECT * FROM `categories` WHERE `name_category` = '$name_category'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $errors[] = "Query failed: " . mysqli_error($conn);
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}

// Handle form submission for updating the category
if (isset($_POST['submit'])) {
    $name_category = mysqli_real_escape_string($conn, $_POST['name_category']);
    $categorie_id = mysqli_real_escape_string($conn, $_POST['categorie_id']);

    // Update the category details in the database
    $update_query = "UPDATE `categories` SET `name_category` = '$name_category' WHERE `categorie_id` = '$categorie_id'";

    if (mysqli_query($conn, $update_query)) {
        $success_msg = "Category updated successfully!";
    } else {
        $errors[] = "Error updating category: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update category</title>
    <link rel="stylesheet" href="../admin/css/author_category.css">
</head>
<body>
<h2>Update Name of Category</h2>
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
        <input type="hidden" name="categorie_id" value="<?php echo isset($row['categorie_id']) ? htmlspecialchars($row['categorie_id'], ENT_QUOTES) : ''; ?>">
        <label for="name">Update category:</label>
        <input type="text" id="name" name="name_category" required value="<?php echo isset($row['name_category']) ? htmlspecialchars($row['name_category'], ENT_QUOTES) : ''; ?>"><br><br>
        <button type="submit" name="submit">Save Category</button>
    </form>
</body>
</html>

<?php
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php');
?>
