<?php
include('../admin/includs/header.php');
?>

<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'database') or die('Connection failed: ' . mysqli_connect_error());

// Fetch authors from database
$author_query = mysqli_query($conn, "SELECT * FROM authors");
$authors = mysqli_fetch_all($author_query, MYSQLI_ASSOC);

// Fetch categories from database
$category_query = mysqli_query($conn, "SELECT * FROM categories");
$categories = mysqli_fetch_all($category_query, MYSQLI_ASSOC);

if (isset($_GET['title'])) {
    $title = $_GET['title'];
    $query = "SELECT * FROM `book` WHERE `title` = '$title'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}

// Handle form submission for updating the book
if (isset($_POST['update_product'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author_id = $_POST['author_id'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];
    $file = $_FILES['file']['name'];
    
    // File upload directory
    $target_dir = "uploaded_img/";
    
    // Move uploaded image to specified directory
    if (!empty($image)) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
    } else {
        $image = $row['cover'];
    }
    
    // Move uploaded file to specified directory
    if (!empty($file)) {
        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $file);
    } else {
        $file = $row['file'];
    }

    // Update the book details in the database
    $update_query = "UPDATE book SET title = '$title', author_id = '$author_id', category_id = '$category_id', cover = '$image', file = '$file' WHERE title = '$title'";
    
    if (mysqli_query($conn, $update_query)) {
        echo "Book updated successfully!";
    } else {
        echo "Error updating book: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/book.css">
    <title>Update Book</title>
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Form Container */
form.add_book {
    background-color: #ffffff;
    border: 1px solid #cccccc;
    border-radius: 5px;
    padding: 20px;
    margin: 50px auto;
    width: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.add_book {
    max-width: 400px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
}

.add_book label {
    display: block;
    margin-bottom: 2px;
    margin-left: -200px;
}

.add_book input[type="text"],
.add_book input[type="file"],
.add_book select {
    width: calc(100% - 22px);
    padding: 8px;
    margin-bottom: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.add_book button[type="submit"] {
    background-color: #089da1;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.add_book button[type="submit"]:hover {
    background-color: #079499;
}

/* Responsive Design */
@media (max-width: 768px) {
    form.add_book {
        width: 80%;
    }
}

@media (max-width: 480px) {
    form.add_book {
        width: 95%;
    }
}

    </style>
</head>
<body>
<form class="add_book" method="post" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required value="<?php echo isset($row['title']) ? $row['title'] : ''; ?>"><br><br>
    <label for="author_id">Author:</label>
    <select id="author_id" name="author_id" required>
        <option value="">Select Author</option>
        <?php foreach ($authors as $author): ?>
            <option value="<?php echo $author['author_id']; ?>" <?php echo (isset($row['author_id']) && $row['author_id'] == $author['author_id']) ? 'selected' : ''; ?>>
                <?php echo $author['name_author']; ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    <label for="category_id">Category:</label>
    <select id="category_id" name="category_id" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['categorie_id']; ?>" <?php echo (isset($row['categorie_id']) && $row['categorie_id'] == $category['categorie_id']) ? 'selected' : ''; ?>>
                <?php echo $category['name_category']; ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    <label for="image">Image:</label>
    <input type="file" id="image" name="image"><br><br>
    <label for="file">File:</label>
    <input type="file" id="file" name="file"><br><br>
    <button type="submit" name="update_product">Update</button>
</form>
</body>
</html>
<?php
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php');
?>