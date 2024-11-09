<?php
session_start();

// Checking if the user is already logged in; if yes, redirect based on their role
if (isset($_SESSION['user_id'])) {
    $user_role = $_SESSION['user_role'];
    switch ($user_role) {
        case 'admin':
            header("Location: admin.php");
            break;
        case 'student':
            header("Location: StudentDashboard.php");
            break;
        default:
            // Handle unrecognized roles or errors here
            break;
    }
    exit();
}

// Include your database connection script here
require('db.php');

// Defining variables to store form data
$username = $password = "";
$error = "";

// Checking if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data (you should add more validation as needed)
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query the database to check if the user exists and fetch their role and hashed password
    $sql = "SELECT id, role, password FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            // Verify the password using password_verify
            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables and redirect based on role
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['username'] = $username; // Set the 'username' session variable
                switch ($row['role']) {
                    case 'admin':
                        header("Location: admin.php");
                        break;
                    case 'student':
                        header("Location: StudentDashboard.php");
                        break;
                    default:
                        // Handle unrecognized roles or errors here
                        $error = "Unknown role: " . $row['role'];
                        break;
                }
                exit();
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Database query error: " . mysqli_error($conn);
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
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
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
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Login">
        </form>

        <?php
        // Displaying error message if login failed
        if (!empty($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>

        
    </div>
</body>
</html>
