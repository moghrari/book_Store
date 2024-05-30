<?php 
session_start(); // Start the session to track logged-in user
include 'config.php'; // Include database configuration file

// Initialize variables
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the POST request
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Query to check if the user exists
    $query = "SELECT * FROM users WHERE name = '$username'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['user_id']; // Store user ID or any other information you need
            
            // Redirect to books page
            header("Location: book.php");
            exit;
        } else {
            $error = 'Incorrect password.';
        }
    } else {
        $error = 'No user found with that username.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 300px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #089da1;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #067d7d;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php 
        if (!empty($error)) {
            echo "<div class='error'>$error</div>";
        }
        ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <p>don't have an account? <a href="sinup.php">register now</a></p>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
