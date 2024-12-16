<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teetrend_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database for the user with the provided email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password using password_verify
        if (password_verify($password, $user['password'])) {
            // Password is correct, login successful
            echo "Login successful!";
            // Redirect to the homepage (after login)
            header("Location: index.html");
            exit();
        } else {
            // Incorrect password
            echo "Incorrect password!";
        }
    } else {
        // User does not exist
        echo "No user found with that email!";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tee-Trend</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-size: cover; /* Ensures the image covers the entire viewport */
            background-image: url('loginbg.jpg'); /* Adjust path to image */
            background-repeat: no-repeat; /* Prevents repeating the image */
            background-position: center center; /* Centers the image */
            margin: 0; /* Removes any default margins */
            height: 100vh; /* Ensures the background covers the entire page height */

        }

        /* Login Section */
        .login-section {
            display: flex;
            margin-left : 150px;
            align-items: center;
            height: 100vh;
            /* background-color: #f4f4f4;                             */
        }

        .login-container {
            background-color: transparant;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.9);
            
            width: 400px;
            
        }

        .login-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color:white
        }

        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-size: 16px;
            color:white;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: white;
            color: gray;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        .login-container button:hover {
            background-color: #FFE893;
        }

        .signup-link p {
            font-size: 14px;
            margin-top: 20px;
        }

        .signup-link a {
            text-decoration: none;
            color: white;
        }

    </style>
</head>
<body>

    <section class="login-section">
        <div class="login-container">
            <h1>Login to Tee-Trend</h1>
            <form action="login.php" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <button type="submit">Login</button>
            </form>

            <div class="signup-link">
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </div>
    </section>

</body>
</html>
