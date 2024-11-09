<?php
session_start();

// Check if the user is logged in as a student; if not, redirect to the login page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Include your database connection script here
require('db.php');

// Get the student's ID from the session
$student_id = $_SESSION['user_id'];

// Use prepared statement to prevent SQL injection
$sql = "SELECT r.Room_Number, r.Room_Type, r.Room_Status, s.First_Name, s.Last_Name, re.Name AS Residence_Name
        FROM student s
        LEFT JOIN room r ON s.Room_ID = r.Room_ID
        LEFT JOIN residence re ON r.Residence_ID = re.Residence_ID
        WHERE s.Student_ID = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $student_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Allocation Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        p {
            margin-bottom: 10px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Room Allocation Details</h2>

        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $roomNumber = htmlspecialchars($row['Room_Number']);
            $roomType = htmlspecialchars($row['Room_Type']);
            $residence = htmlspecialchars($row['Residence_Name']);
            $roomStatus = htmlspecialchars($row['Room_Status']);
            $firstName = htmlspecialchars($row['First_Name']);
            $lastName = htmlspecialchars($row['Last_Name']);
        ?>
            <p>Congratulations, <?php echo $firstName . " " . $lastName; ?>!</p>
            <p>You have been allocated the following room:</p>
            <ul>
                <li><strong>Room Number:</strong> <?php echo $roomNumber; ?></li>
                <li><strong>Room Type:</strong> <?php echo $roomType; ?></li>
                <li><strong>Residence:</strong> <?php echo $residence; ?></li>
                <li><strong>Room Status:</strong> <?php echo $roomStatus; ?></li>
            </ul>
        <?php
        } 
        else {
        ?>
            <p>Sorry, you have not been allocated a room at this time. Please contact the residence office for assistance.</p>
        <?php
        }
        ?>

        <a href="StudentDashboard.php">Back to Student Dashboard</a>
    </div>
</body>
</html>



