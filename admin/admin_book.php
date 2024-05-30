<?php
include('../admin/includs/header.php');
?>

<?php
// Include database connection file
$conn = mysqli_connect('localhost', 'root', '', 'database') or die('Connection failed: ' . mysqli_connect_error());

// If delete button is clicked
if (isset($_POST['delete'])) {
    $book_id = $_POST['book_id'];
    // Delete the book from the database
    $delete_query = "DELETE FROM book WHERE id = '$book_id'";
    if (mysqli_query($conn, $delete_query)) {
        $success_msg = "Book deleted successfully!";
    } else {
        $errors[] = "Error deleting book: " . mysqli_error($conn);
    }
}

// Fetch authors from database
$author_query = mysqli_query($conn, "SELECT * FROM authors");
$authors = mysqli_fetch_all($author_query, MYSQLI_ASSOC);

// Fetch categories from database
$category_query = mysqli_query($conn, "SELECT * FROM categories");
$categories = mysqli_fetch_all($category_query, MYSQLI_ASSOC);

// If form is submitted
if (isset($_POST['add_product'])) {
    // Get form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author_id = $_POST['author_id'];
    $categorie_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];
    $file = $_FILES['file']['name'];

    // File upload directory
    $target_dir = "uploaded_img/";

    // Move uploaded image to specified directory
    move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
    // Move uploaded file to specified directory
    move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $file);

    // Insert product into books table
    $insert_query = "INSERT INTO book (title, author_id, category_id, cover, file) VALUES ('$title', '$author_id', '$categorie_id', '$image', '$file')";
    if (mysqli_query($conn, $insert_query)) {
        $success_msg = "Book added successfully!";
    } else {
        $errors[] = "Error adding book: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="../admin/css/book.css">
    <style>
        .btn_b a {
    text-decoration: none;
    background-color: #089da1;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
    margin-top: 9px;
}
    </style>
</head>
<body>
    <h2>Add Book</h2>
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
    <form method="post" enctype="multipart/form-data" class="add_book">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="author_id">Author:</label>
        <select id="author_id" name="author_id" required>
            <option value="">Select Author</option>
            <?php foreach ($authors as $author): ?>
                <option value="<?php echo $author['author_id']; ?>"><?php echo $author['name_author']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['categorie_id']; ?>"><?php echo $category['name_category']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" required><br><br>
        <label for="file">File:</label>
        <input type="file" id="file" name="file" required><br><br>
        <button type="submit" name="add_product">Add Book</button>
    </form>
    <section id="show-product">
        <h2>Books</h2>
        <?php
        // Fetch products from database
        $result = mysqli_query($conn, "SELECT id, title, name_author, name_category, cover FROM book INNER JOIN authors ON book.author_id = authors.author_id INNER JOIN categories ON book.category_id = categories.categorie_id");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class ='show_book'>";
                echo "<img src='uploaded_img/" . $row['cover'] . "' alt='Cover Image' width='200'><br>";
                echo "<strong>Title:</strong> " . $row['title'] . "<br>";
                echo "<strong>Author:</strong> " . $row['name_author'] . "<br>";
                echo "<strong>Category:</strong> " . $row['name_category'] . "<br>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='book_id' value='" . $row['id'] . "'>";
                echo "<div class='btn_b'>";
                echo "<input type='submit' value='Delete' name='delete'>" . "<br>";
                echo "<a href='../admin/update_book.php?title=" . urlencode($row['title']) . "'>update</a>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "No products found!";
        }
        ?>
    </section>

</body>
</html>
<?php
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php');
?>