<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Database connection code (replace with your database connection)
require('db.php');

// Initialize variables
$errors = array();

// Handle form submissions (allocate rooms to students)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['allocate_room'])) {
        // Check if 'student_id' and 'room_id' are present in the $_POST array
        if (isset($_POST['student_id']) && isset($_POST['room_id'])) {
            $student_id = $_POST['student_id'];
            $room_id = $_POST['room_id'];

            // Update the room status to 'Occupied' in the database
            $update_room_sql = "UPDATE room SET Room_Status = 'Occupied' WHERE Room_ID = $room_id";
           
            // Update the Room_ID in the student table
            $update_student_sql = "UPDATE student SET Room_ID = $room_id WHERE Student_ID = $student_id";

            // Debugging: Print the SQL queries
            echo "Debug: SQL Query 1 (Update Room Status): $update_room_sql<br>";
            echo "Debug: SQL Query 2 (Update Student Room_ID): $update_student_sql<br>";

            // Perform the updates
            if (mysqli_query($conn, $update_room_sql) && mysqli_query($conn, $update_student_sql)) {
                header("Location: rooms.php");
                exit();
            } else {
                // Handle error and print the error message
                array_push($errors, "Error: " . mysqli_error($conn));
            }
        } else {
            // Handle the case when 'student_id' or 'room_id' is not present in the POST data
            array_push($errors, "Student ID or Room ID not provided in the POST data.");
        }
    }
}

// Fetch and display existing rooms
$sql = "SELECT * FROM room WHERE Room_Status = 'Vacant'";
$result = mysqli_query($conn, $sql);

$vacant_rooms = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $vacant_rooms[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocate Rooms</title>
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

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        td select {
            width: 100%;
            padding: 5px;
        }

        td button {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 5px 10px;
            cursor: pointer;
        }

        td button:hover {
            background-color: #0056b3;
        }

        .error {
            color: #ff0000;
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
    <h2>Allocate Rooms to Students</h2>

    <?php
    // Display errors, if any
    if (!empty($errors)) {
        echo '<div class="error">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
    ?>

    <!-- Display vacant rooms and allow room allocation to students -->
    <table>
        <thead>
            <tr>
                <th>Room Number</th>
                <th>Room Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vacant_rooms as $room) : ?>
                <tr>
                    <td><?php echo $room['Room_Number']; ?></td>
                    <td><?php echo $room['Room_Type']; ?></td>
                    <td>
                        <form method="post" action="rooms.php">
                            <input type="hidden" name="room_id" value="<?php echo $room['Room_ID']; ?>">
                            <select name="student_id">
                                <?php
                                // Fetch and display a list of students who have not been allocated a room
                                $students_sql = "SELECT Student_ID, First_Name, Last_Name FROM student WHERE Room_ID IS NULL";
                                $students_result = mysqli_query($conn, $students_sql);

                                if ($students_result) {
                                    while ($student_row = mysqli_fetch_assoc($students_result)) {
                                        $student_id = $student_row['Student_ID'];
                                        $student_name = $student_row['First_Name'] . ' ' . $student_row['Last_Name'];
                                        echo "<option value='$student_id'>$student_name</option>";
                                    }
                                }
                                ?>
                            </select>
                            <button type="submit" name="allocate_room">Allocate</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="admin.php">Back to Admin Dashboard</a>
</body>
</html>
