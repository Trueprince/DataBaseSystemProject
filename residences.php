<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include your database connection script here
require('db.php'); // Replace with your actual database connection script

// Initialize variables
$residence_id = "";
$current_occupancy = 0; // Initialize current occupancy to 0

// Check if a Residence ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['residence_id']) && is_numeric($_POST['residence_id'])) {
    $residence_id = $_POST['residence_id'];

    // Fetch the number of students in the residence
    $count_students_sql = "SELECT COUNT(*) AS student_count FROM room WHERE Residence_ID = $residence_id";
    $result = mysqli_query($conn, $count_students_sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $current_occupancy = $row['student_count']; // Get the count of students
    } else {
        // Error fetching student count
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    // Update the "Current_Occupancy" in the "residence" table
    $update_occupancy_sql = "UPDATE residence SET Current_Occupancy = $current_occupancy WHERE Residence_ID = $residence_id";

    if (mysqli_query($conn, $update_occupancy_sql)) {
        // Successfully updated current occupancy, redirect to view residence table
        header("Location: view_residence.php");
        exit();
    } else {
        // Error updating current occupancy
        echo "Error: " . mysqli_error($conn);
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the case when Residence ID is not provided in the POST data
    // You can redirect or display an error message as needed
    // For example, you can redirect to the dashboard page
    header("Location: view_residence.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Current Occupancy</title>
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

        .container {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
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
    <h2>Update Current Occupancy</h2>
    <div class="container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="residence_id">Residence ID:</label>
            <input type="number" id="residence_id" name="residence_id" required><br>
            <button type="submit">Update Occupancy</button>
        </form>
        <a href="view_residence.php">Back to residence</a>
    </div>
</body>
</html>




