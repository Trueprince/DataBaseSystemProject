<?php
session_start();

// Check if the user is logged in and has the "manager" role; if not, redirect to the login page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include your database connection script here
require('db.php');

// Initialize an empty array for storing messages to display after processing applications
$messages = [];

// Check if the form for processing applications was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['process_application'])) {
    $student_id = $_POST['student_id'];
    $action = $_POST['action'];

    // Initialize the SQL query
    $sql = '';

    // Implement the logic to update the application status in the database based on the manager's decision
    // Example SQL queries:
    if ($action === 'approve') {
        $sql = "UPDATE student SET Application_Status = 'Approved' WHERE Student_ID = $student_id";
    } elseif ($action === 'decline') {
        $sql = "UPDATE student SET Application_Status = 'Declined' WHERE Student_ID = $student_id";
    }

    // Execute the SQL query
    if (!empty($sql)) {
        if (mysqli_query($conn, $sql)) {
            // Add a success message
            $messages[] = "Application for Student ID $student_id has been $action.";
        } else {
            // Add an error message if the query fails
            $messages[] = "Failed to $action the application for Student ID $student_id.";
        }
    }
}

// Fetch the list of residence applications from the database
$sql = "SELECT * FROM student WHERE Application_Status IN ('Allocated', 'Pending')";
$result = mysqli_query($conn, $sql);


// Initialize an empty array to store application data
$applications = [];

if ($result) {
    // Fetch and populate the application data
    while ($row = mysqli_fetch_assoc($result)) {
        $applications[] = $row;
    }
}

// HTML for the view applications page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applications</title>
    <!-- Include CSS and any other necessary assets -->
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

        p {
            margin: 5px 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        form {
            display: inline-block;
        }

        select {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <h2>View Applications</h2>

    <!-- Display messages for application processing -->
    <?php foreach ($messages as $message) : ?>
        <p><?php echo $message; ?></p>
    <?php endforeach; ?>

    <!-- Display a list of residence applications with options to approve or decline -->
    <ul>
        <?php foreach ($applications as $application) : ?>
            <li>
                Student ID: <?php echo $application['Student_ID']; ?><br>
                Name: <?php echo $application['First_Name'] . ' ' . $application['Last_Name']; ?><br>
                Gender: <?php echo $application['Gender']; ?><br>
                Application Status: <?php echo $application['Application_Status']; ?><br>
                Residence Preference: <?php echo $application['Residence_Preference']; ?><br>
                Application Date: <?php echo $application['Application_Date']; ?><br>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="student_id" value="<?php echo $application['Student_ID']; ?>">
                    <select name="action" required>
                        <option value="approve">Approve</option>
                        <option value="decline">Decline</option>
                    </select>
                    <input type="submit" name="process_application" value="Process">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="admin.php">Back To Dashboard</a>
</body>
</html>
