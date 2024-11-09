<?php
session_start();

// Check if the 'user_id' session variable is set
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle the error as needed
    header("Location: login.php");
    exit();
}

// Include your database connection script here
require('db.php'); // Ensure this line points to your database connection script

// Fetch student's information from the database
$student_id = $_SESSION['user_id'];
$sql = "SELECT * FROM student WHERE Student_ID = $student_id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query error: " . mysqli_error($conn));
}

// Initialize an empty student data array
$student_data = array();

// Check if data was retrieved
if (mysqli_num_rows($result) > 0) {
    $student_data = mysqli_fetch_assoc($result);
} else {
    // Handle the case where student data is not available
    $student_data = array(
        'First_Name' => 'N/A',
        'Last_Name' => 'N/A',
        'Gender' => 'N/A',
        'Date_Of_Birth' => 'N/A',
        'Phone' => 'N/A',
        'Email' => 'N/A',
        'Program_Department' => 'N/A',
        'Current_Year_Of_Study' => 'N/A',
        'Residence_Preference' => 'N/A',
        'Application_Status' => 'N/A',
    );
}

// HTML for the student dashboard
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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

        h3 {
            color: #333;
        }

        p {
            margin: 5px 0;
        }

        strong {
            font-weight: bold;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
        }

        .dashboard-container {
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
    <div class="dashboard-container">
        <h2>Welcome to Your Student Dashboard</h2>

        <h3>Your Information</h3>
        <p><strong>Name:</strong> <?php echo isset($student_data['First_Name']) ? $student_data['First_Name'] . ' ' . $student_data['Last_Name'] : 'N/A'; ?></p>
        <p><strong>Gender:</strong> <?php echo isset($student_data['Gender']) ? $student_data['Gender'] : 'N/A'; ?></p>
        
        <p><strong>Phone:</strong> <?php echo isset($student_data['Phone']) ? $student_data['Phone'] : 'N/A'; ?></p>
        <p><strong>Email:</strong> <?php echo isset($student_data['Email']) ? $student_data['Email'] : 'N/A'; ?></p>
        <p><strong>Program/Department:</strong> <?php echo isset($student_data['Program_Department']) ? $student_data['Program_Department'] : 'N/A'; ?></p>
        
        <p><strong>Residence Preference:</strong> <?php echo isset($student_data['Residence_Preference']) ? $student_data['Residence_Preference'] : 'N/A'; ?></p>
        <p><strong>Application Status:</strong> <?php echo isset($student_data['Application_Status']) ? $student_data['Application_Status'] : 'N/A'; ?></p>

        <!-- You can add more information or actions as needed -->

        <a href="allocation_success.php">Check For Room Allocation</a>
        <a href="apply_for_residence.php">Apply For Residence</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
