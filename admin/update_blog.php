<?php
include('../admin/includs/header.php');

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'database') or die('Connection failed: ' . mysqli_connect_error());

$row = null; // Initialize $row to avoid undefined variable error

if (isset($_GET['name'])) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $query = "SELECT * FROM `blog` WHERE `name` = '$name'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}

// Handle form submission for updating the blog
if (isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $text = mysqli_real_escape_string($conn, $_POST['text']);
    $image = $_FILES['image']['name'];
    $target_dir = "uploaded_img/";

    // Move uploaded image to specified directory
    if (!empty($image)) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
    } else {
        $image = isset($row['image']) ? $row['image'] : '';
    }

    // Update the blog details in the database
    $update_query = "UPDATE `blog` SET `name` = '$name', `text` = '$text', `image` = '$image' WHERE `name` = '$name'";

    if (mysqli_query($conn, $update_query)) {
        echo "Blog updated successfully!";
    } else {
        echo "Error updating blog: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Blog</title>
    <style>
        /* blog.css */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        section {
            width: 450px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h3.add_product {
            text-align: center;
            color: #333;
        }

        .form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form input[type="text"],
        .form input[type="file"],
        .form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        .form input[type="text"] {
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form input[type="file"] {
            border: none;
            background: none;
        }

        .form input[type="submit"] {
            background-color: #089da1;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .form input[type="text"]:focus {
            background-color: #079499;
            outline: none;
        }

        .form--submit {
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>
<section>
    <form class="form" method="post" enctype="multipart/form-data">
        <h3 class="add_product">Update Blog</h3>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required value="<?php echo isset($row['name']) ? htmlspecialchars($row['name'], ENT_QUOTES) : ''; ?>"><br>
        <label for="text">Text:</label>
        <input type="text" id="text" name="text" required value="<?php echo isset($row['text']) ? htmlspecialchars($row['text'], ENT_QUOTES) : ''; ?>"><br>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image"><br>
        <input type="submit" value="Update Blog" name="update_product" class="form--submit">
    </form>
</section>
</body>
</html>

<?php
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php');
?>
