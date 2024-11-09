<?php
session_start();

// Check if the user is logged in as a student; if not, redirect to the login page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Database Connection
require('db.php');

// Defining variables to store form data
$first_name = $last_name = $gender = $date_of_birth = $phone = $email = $program_department = $current_year_of_study = $residence_preference = "";
$error = "";

// Checking if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Validate and sanitize form data

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $program_department = mysqli_real_escape_string($conn, $_POST['program_department']);
    $current_year_of_study = mysqli_real_escape_string($conn, $_POST['current_year_of_study']);
    $residence_preference = mysqli_real_escape_string($conn, $_POST['residence_preference']);

// Checking if the student already has an active application
    $student_id = $_SESSION['user_id'];
    $check_sql = "SELECT * FROM student WHERE Student_ID = $student_id AND Application_Status = 'Pending'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "You already have a pending residence application. Please wait for the response.";
    } else {
// Inserting the new residence application into the database
        $application_date = date("Y-m-d");

        $insert_sql = "INSERT INTO student (Student_ID, First_Name, Last_Name, Gender, Date_Of_Birth, Phone, Email, Program_Department, Current_Year_Of_Study, Residence_Preference, Application_Status, Application_Date)
            VALUES ($student_id, '$first_name', '$last_name', '$gender', '$date_of_birth', '$phone', '$email', '$program_department', '$current_year_of_study', '$residence_preference', 'Pending', '$application_date')";

        if (mysqli_query($conn, $insert_sql)) {
// Application successful, you can redirect to a confirmation page or student dashboard
            header("Location: application_success.php");
            exit();
        } else {
            $error = "Error submitting the application. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Residence</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            text-align: center;
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
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        select {
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

        p.error-message {
            color: red;
            font-weight: bold;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Apply for Residence</h2>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label>Gender:</label>
        <input type="radio" name="gender" value="male" required> Male
        <input type="radio" name="gender" value="female" required> Female
        <!-- Add more gender options if needed --><br>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="program_department">Program/Department:</label>
        <input type="text" id="program_department" name="program_department" required><br>

        <label for="current_year_of_study">Current Year of Study:</label>
        <input type="text" id="current_year_of_study" name="current_year_of_study" required><br>

        <label for="residence_preference">Residence Preference:</label>
        <select id="residence_preference" name="residence_preference" required>
            <option value="Single">Single</option>
            <option value="Shared">Shared</option>
            <option value="Suite">Suite</option>
        </select><br>

        <input type="submit" value="Submit Application">
    </form>

    <?php
    // Displaying error message if there was an error submitting the application
    if (!empty($error)) {
        echo "<p class='error-message'>$error</p>";
    }
    ?>

    <a href="StudentDashboard.php">Back to Student Dashboard</a>

</body>
</html>
