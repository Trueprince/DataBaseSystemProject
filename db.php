<?php
$hostname = "localhost";
$username = "root";
$password = ""; 

$database = "students_residence_db"; // Replace with your actual database name

// Create a database connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 
else {
}
?>
