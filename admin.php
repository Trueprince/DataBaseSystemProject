<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include your database connection script here
require('db.php');

$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Unknown";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to the Manager Dashboard</h2>
        <p>Hello, <?php echo htmlspecialchars($username); ?> (Manager)!</p>
        
        <h3>Manage:</h3>
        <ul>
            <li><a href="manage_residences.php">Residences</a></li>
            <li><a href="manage_rooms.php">Rooms</a></li>
            <li><a href="view_residence.php">Current Occupancy</a></li>
            <li><a href="manage_applications.php">Manage Applications</a></li>
            <li><a href="view_applications.php">View Applications</a></li>
            

        </ul>

        <h3>Allocate:</h3>
        <ul>
            <li><a href="rooms.php">Rooms</a></li>
        </ul>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
