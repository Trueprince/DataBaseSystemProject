<?php
session_start();

// Check if the user is logged in as a student; if not, redirect to the login page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Include your database connection script here
require('db.php');


$user_id = $_SESSION['user_id'];

// Fetch the status of the student's residence application
$application_status = "";
$student_info = array(); // Initialize an empty array for student information

// Implement querying the database to get the application status and student information
$sql = "SELECT * FROM student WHERE Student_ID = $user_id";

// Execute the SQL query
$result = mysqli_query($conn, $sql);

// Check if the query was successful and fetch the application status and student information
if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $application_status = $row['Application_Status'];
    $student_info = $row; // Store all student information
}

// Close the database connection
mysqli_close($conn);

// HTML for the application status page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status</title>
    
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
            margin-top: 20px;
        }

        h3 {
            color: #333;
        }

        p {
            margin: 5px 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Application Status</h2>
        <p>Your residence application status:</p>
        <p>Status: <?php echo $application_status; ?></p>

        <h3>Your Student Information</h3>
        <ul>
            <li>Student ID: <?php echo $student_info['Student_ID']; ?></li>
            <li>First Name: <?php echo $student_info['First_Name']; ?></li>
            <li>Last Name: <?php echo $student_info['Last_Name']; ?></li>
            <li>Gender: <?php echo $student_info['Gender']; ?></li>
            <li>Date of Birth: <?php echo $student_info['Date_of_Birth']; ?></li>
            <li>Phone: <?php echo $student_info['Phone']; ?></li>
            <li>Email: <?php echo $student_info['Email']; ?></li>
            <li>Program Department: <?php echo $student_info['Program_Department']; ?></li>
            <li>Current Year of Study: <?php echo $student_info['Current_Year_of_Study']; ?></li>
            <li>Room Allocation: <?php echo $student_info['Room_Allocation']; ?></li>
            <li>Residence Preference: <?php echo $student_info['Residence_Preference']; ?></li>
            <li>Application Date: <?php echo $student_info['Application_Date']; ?></li>
        </ul>

        <!-- Include a link to the student dashboard -->
        <a href="StudentDashboard.php">Back to Student Dashboard</a>
    </div>
</body>
</html>
