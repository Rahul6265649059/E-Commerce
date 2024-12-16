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
    $confirm_password = $_POST['confirm_password'];

    // Validate email and password (basic validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        // Redirect to login page or homepage after successful registration
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <title>Sign Up - Tee-Trend</title>
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

        /* Sign Up Section */
        .signup-section {
            display: flex;
            margin-left: 150px;
            align-items: center;
            height: 100vh;
            /* background-color: #f4f4f4; */
        }

        .signup-container {
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.9);
            /* text-align: center; */
            width: 400px;

        }

        .signup-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .signup-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .signup-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .signup-container button {
            width: 100%;
            padding: 12px;
            background-color: white;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        .signup-container button:hover {
            background-color: #FFE893;
        }

        .login-link p {
            font-size: 14px;
            margin-top: 20px;
        }

        .login-link a {
            text-decoration: none;
            color: #ff5733;
        }

    </style>
</head>
<body>

    <!-- SIGN UP FORM SECTION -->
    <section class="signup-section">
        <div class="signup-container">
            <h1>Create an Account</h1>
            <form action="signup.php" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>

                <button type="submit">Sign Up</button>
            </form>

            <div class="login-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </section>

</body>
</html>
