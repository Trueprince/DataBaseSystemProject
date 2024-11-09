<?php
session_start();

// Check if the user is logged in and has the necessary role (e.g., admin or manager)
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include your database connection script here
require('db.php'); // Replace with your actual database connection script

// Fetch residence data from the database
$residence_query = "SELECT * FROM residence";
$residence_result = mysqli_query($conn, $residence_query);

// Check if there are any residences
if (mysqli_num_rows($residence_result) > 0) {
    // Create an HTML table to display residence data
    $table_html = '<table>
                    <thead>
                        <tr>
                            <th>Residence ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Capacity</th>
                            <th>Current Occupancy</th>
                            <th>Residence Manager</th>
                            <th>Application Deadline</th>
                            <th>Availability Status</th>
                        </tr>
                    </thead>
                    <tbody>';

    while ($row = mysqli_fetch_assoc($residence_result)) {
        // Fetch the number of students in the residence
        $count_students_sql = "SELECT COUNT(*) AS student_count FROM room WHERE Residence_ID = " . $row['Residence_ID'];
        $count_students_result = mysqli_query($conn, $count_students_sql);

        if ($count_students_result) {
            $count_row = mysqli_fetch_assoc($count_students_result);
            $current_occupancy = $count_row['student_count'];
        } else {
            // Error fetching student count
            echo "Error: " . mysqli_error($conn);
            exit();
        }

        $table_html .= '<tr>
                            <td>' . $row['Residence_ID'] . '</td>
                            <td>' . $row['Name'] . '</td>
                            <td>' . $row['Address'] . '</td>
                            <td>' . $row['Capacity'] . '</td>
                            <td>' . $current_occupancy . '</td>
                            <td>' . $row['Residence_Manager'] . '</td>
                            <td>' . $row['Application_Deadline'] . '</td>
                            <td>' . $row['Availability_Status'] . '</td>
                        </tr>';
    }

    $table_html .= '</tbody></table>';
} else {
    // No residences found in the database
    $table_html = '<p>No residences found in the database.</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Residences</title>
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
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007BFF;
            color: #fff;
        }

        table tr:hover {
            background-color: #e0e0e0;
        }
            
    </style>
</head>
<body>
    <h2>View Residences</h2>
    <div class="container">
        <?php echo $table_html; ?>

        <a href="admin.php">Back to Dashboard</a>
    </div>
</body>
</html>
