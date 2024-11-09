<?php
session_start();

// Checking if the user is logged in and has the necessary role 
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
// Database connection script here
require('db.php');

// Initialize the errors array
$errors = array();

// Function to get Room_Number for a given Room_ID
function getRoomNumber($conn, $roomID)
{
    $room_query = "SELECT Room_Number FROM room WHERE Room_ID = $roomID";
    $room_result = mysqli_query($conn, $room_query);

    if ($room_result && mysqli_num_rows($room_result) > 0) {
        $room_data = mysqli_fetch_assoc($room_result);
        return $room_data['Room_Number'];
    } else {
        return "N/A";
    }
}

// Fetch and display existing applications
$sql = "SELECT * FROM student";
$result = mysqli_query($conn, $sql);

$applications = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Format the date of birth
        $dateOfBirth = isset($row['Date_Of_Birth']) ? date('Y-m-d', strtotime($row['Date_Of_Birth'])) : "";

        // Handle NULL value for Current_Year_Of_Study
        $currentYear = isset($row['Current_Year_Of_Study']) ? $row['Current_Year_Of_Study'] : "N/A";

        // Add the data to the applications array
        $applications[] = array(
            'Student_ID' => $row['Student_ID'],
            'First_Name' => $row['First_Name'],
            'Last_Name' => $row['Last_Name'],
            'Gender' => $row['Gender'],
            //'Date_Of_Birth' => $dateOfBirth,
            'Phone' => $row['Phone'],
            'Email' => $row['Email'],
            'Program_Department' => $row['Program_Department'],
            //'Current_Year_Of_Study' => $currentYear,
            'Application_Status' => $row['Application_Status'],
            'Room_ID' => $row['Room_ID'],
            'Residence_Preference' => $row['Residence_Preference'],
            'Application_Date' => $row['Application_Date']
        );
    }
}

// Handle form submissions (update application status)
if (isset($_POST['update_status'])) {
    $student_id = $_POST['student_id'];
    $new_status = $_POST['new_status'];

// Update the application status in the database
    $update_sql = "UPDATE student SET Application_Status = '$new_status' WHERE Student_ID = $student_id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: manage_applications.php");
        exit();
    } else {
        array_push($errors, "Failed to update application status");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        select, button {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border-radius: 3px;
        }

        a:hover {
            background-color: #0056b3;
        }

        .error {
            background-color: #ff9999;
            color: #990000;
            padding: 10px;
            margin-top: 10px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Applications</h2>

        <?php
        // Display errors if any
        if (!empty($errors)) {
            echo "<div class='error'>";
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }
        ?>
        
        <!-- Display existing applications and allow status updates -->
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Program/Department</th>
                    
                    <th>Application Status</th>
                    <th>Room ID</th>
                    <th>Residence Preference</th>
                    <th>Application Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application) : ?>
                    <tr>
                        <td><?php echo $application['Student_ID']; ?></td>
                        <td><?php echo $application['First_Name']; ?></td>
                        <td><?php echo $application['Last_Name']; ?></td>
                        <td><?php echo $application['Gender']; ?></td>
                        
                        <td><?php echo $application['Phone']; ?></td>
                        <td><?php echo $application['Email']; ?></td>
                        <td><?php echo $application['Program_Department']; ?></td>
                        
                        <td><?php echo $application['Application_Status']; ?></td>
                        <td><?php echo getRoomNumber($conn, $application['Room_ID']); ?></td>
                        <td><?php echo $application['Residence_Preference']; ?></td>
                        <td><?php echo $application['Application_Date']; ?></td>
                        <td>
                            <form method="post" action="manage_applications.php">
                                <input type="hidden" name="student_id" value="<?php echo $application['Student_ID']; ?>">
                                <select name="new_status">
                                    <option value="Applied">Applied</option>
                                    <option value="Allocated">Allocated</option>
                                    <option value="Declined">Declined</option>
                                </select>
                                <button type="submit" name="update_status">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="admin.php">Back to Dashboard</a>
    </div>
</body>
</html>
