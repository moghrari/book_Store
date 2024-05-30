<?php
include('../admin/includs/header.php');
?>

<?php
// Include database connection file
$conn = mysqli_connect('localhost', 'root', '', 'database') or die('Connection failed: ' . mysqli_connect_error());

// Initialize variables
$name = '';
$errors = array();
$success_msg = '';

// If form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $author = mysqli_real_escape_string($conn, $_POST['name']);

    // Insert name into database
    $insert_query = "INSERT INTO authors (name_author) VALUES ('$author')";
    if (mysqli_query($conn, $insert_query)) {
        $success_msg = "has been saved successfully!";
    } else {
        $errors[] = "Error: " . $insert_query . "<br>" . mysqli_error($conn);
    }
}
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `authors` WHERE author_id = '$delete_id'") or die('Query failed');
    header('Location: admin/admin_category.php'); // Replace 'your_page.php' with your actual page name to reload the page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Category</title>
    <link rel="stylesheet" href="../admin/css/author_category.css">
    <style>
        .add_author_category {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
        }

        table {
    width: 500px;
    border-collapse: collapse;
    margin: 20px auto;
    font-family: Arial, sans-serif;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color: #f4f4f4;
    font-weight: bold;
    text-align: center;
}

td {
    background-color: #fff;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Style for the delete button */
.delete-btn {
    padding: 8px 12px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    font-size: 14px;
    margin-left: 20px;
}


/* Style for the update button */
.update-btn {
    padding: 8px 12px;
    background-color:#079499;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    font-size: 14px;
    margin-left: 20px;
}



    </style>
</head>
<body>
    <h2>Save Authors</h2>
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
        <label for="name">Enter :</label>
        <input type="text" id="name" name="name" required value="<?php echo $name; ?>"><br><br>
        <button type="submit" name="submit">Save author</button>
    </form>
    <section class="author-list">
    <h2>Authors List</h2>
    <table>
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all authors from the database
                $select_authors_query = "SELECT author_id, name_author FROM authors";
                $authors_result = mysqli_query($conn, $select_authors_query);

                // Check if any author exists
                if (mysqli_num_rows($authors_result) > 0) {
                    // Loop through each row and display the name_author and action button
                    while ($authors_row = mysqli_fetch_assoc($authors_result)) {
                        echo "<tr>";
                        echo "<td>" . $authors_row['name_author'] . "</td>";
                        echo "<td><a href='?delete=" . $authors_row['author_id'] . "' class='delete-btn' onclick='return confirmDelete();'>Delete</a>
                                  <a class ='update-btn' href='../admin/update_author.php?name_author=" . urlencode($authors_row['name_author']) . "'>update</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No categories found.</td></tr>";
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
</section>
</body>
</html>
<?php
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php');
?>