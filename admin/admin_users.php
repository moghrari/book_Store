<?php
include('../admin/includs/header.php');
include 'config.php';

// Check if the delete button is clicked
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    
    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Delete entries from dependent tables
        $delete_downloads = "DELETE FROM downloads WHERE user_id = ?";
        $stmt = $conn->prepare($delete_downloads);
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();

        $delete_books_opened = "DELETE FROM books_opened WHERE user_id = ?";
        $stmt = $conn->prepare($delete_books_opened);
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();

        // Delete the user from the users table
        $delete_user = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($delete_user);
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        mysqli_commit($conn);

        // User deleted successfully, refresh the page
        exit();
    } catch (Exception $e) {
        // Rollback transaction in case of error
        mysqli_rollback($conn);
        echo "Error: Could not delete user: " . $e->getMessage();
    }
}

// Fetch users information
$query = "SELECT u.user_id, u.name, u.email, 
    (SELECT COUNT(*) FROM downloads d WHERE d.user_id = u.user_id) AS download_count,
    (SELECT COUNT(*) FROM books_opened bo WHERE bo.user_id = u.user_id) AS open_count
    FROM users u";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error: Could not execute the query: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .delete-button {
            background-color: #dc3545;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c82333;
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this user?');
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Users Information</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Books Downloaded</th>
                    <th>Books Opened</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo $row['download_count']; ?></td>
                        <td><?php echo $row['open_count']; ?></td>
                        <td>
                            <a href="?delete=<?php echo $row['user_id']; ?>" class="delete-button" onclick="return confirmDelete();">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php');
?>
