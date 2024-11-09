<?php
session_start();

// Check if the user is already logged in; if yes, redirect to the dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Include your database connection script here
require('db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Add a new input field for role selection in the registration form

    // Validate and sanitize user input (you should implement proper validation and sanitization)
    $username = mysqli_real_escape_string($conn, $username);

    // Hash the password securely using bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database with the hashed password and selected role
    $insert_sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";

    if (mysqli_query($conn, $insert_sql)) {
        // Registration successful, redirect to login page based on the user's role
        if ($role === 'admin') {
            header("Location: admin.php");
        } elseif ($role === 'student') {
            header("Location: StudentDashboard.php");
        } else {
            // Handle unknown role (e.g., display an error message)
        }
        exit();
    } else {
        $error = "Registration failed. Please try again later.";
    }
}

// HTML for the registration form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #007BFF;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 20px;
        }

        select {
            background-color: white;
            color: #333;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p.error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <!-- Add a role selection field -->
        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="admin">Manager</option>
            <option value="student">Student</option>
        </select><br>

        <input type="submit" value="Register">
    </form>

    <?php
    // Display error message if registration failed
    if (isset($error)) {
        echo "<p class='error'>$error</p>";
    }
    ?>

    <!-- Include any other HTML content and JavaScript if needed -->
</body>
</html>
