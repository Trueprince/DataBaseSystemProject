<?php
session_start();

// Check if the user is logged in as a manager; if not, redirect to the login page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include your database connection script here (e.g., db.php)
require('db.php');

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
            // Add a success message to display on the Manager Dashboard
            $_SESSION['messages'][] = "Application for Student ID $student_id has been $action.";
        } else {
            // Add an error message to display on the Manager Dashboard
            $_SESSION['messages'][] = "Failed to $action the application for Student ID $student_id.";
        }
    }

    // Redirect back to the Manager Dashboard
    header("Location: admin.php");
    exit();
} else {
    // If the form was not submitted properly, redirect to the Manager Dashboard
    header("Location: admin.php");
    exit();
}
?>
