<?php
session_start();

// Check if the user is logged in and has the necessary role (e.g., admin or manager)
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include your database connection script here
require('db.php');


// Initialize variables
$student_id = "";
$room_id = "";
$room_number = "";
$room_type = "";
$room_status = "";
$residence_id = "";
$errors = array();

// Fetch and display existing rooms
$sql = "SELECT * FROM room";
$result = mysqli_query($conn, $sql);

$rooms = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row;
    }
}

// Handle form submissions (edit, delete, create)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit_room'])) {
        // Handle room edit request (redirect to a room edit page)
        $room_id = $_POST['room_id'];
        header("Location: edit_room.php?room_id=$room_id");
        exit();
    } elseif (isset($_POST['delete_room'])) {
        // Handle room deletion
        $room_id = $_POST['room_id'];
        $delete_sql = "DELETE FROM room WHERE Room_ID = $room_id";
        if (mysqli_query($conn, $delete_sql)) {
            header("Location: manage_rooms.php");
            exit();
        } else {
            array_push($errors, "Failed to delete room");
        }
    } elseif (isset($_POST['create_room'])) {
        // Handle room creation
        $room_number = $_POST['room_number'];
        $room_type = $_POST['room_type'];
        $room_status = $_POST['room_status'];
        $residence_id = $_POST['residence_id'];

        // Validate and sanitize user input (you should implement proper validation and sanitization)
        $room_number = mysqli_real_escape_string($conn, $room_number);
        $room_type = mysqli_real_escape_string($conn, $room_type);
        $room_status = mysqli_real_escape_string($conn, $room_status);
        $residence_id = mysqli_real_escape_string($conn, $residence_id);

        // Insert the new room into the database
        $insert_sql = "INSERT INTO room (Room_Number, Room_Type, Room_Status, Residence_ID) VALUES ('$room_number', '$room_type', '$room_status', '$residence_id')";

        if (mysqli_query($conn, $insert_sql)) {
            header("Location: manage_rooms.php");
            exit();
        } else {
            array_push($errors, "Failed to create room");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h3 {
            margin-top: 20px;
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

        table td {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #e0e0e0;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin-right: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

        form {
            display: inline;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-top: 5px;
        }

        button[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
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
    </style>
</head>
<body>
    <h2>Manage Rooms</h2>
    <div class="container">

        <!-- Display existing rooms -->
        <table>
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Room Status</th>
                    <th>Residence</th> 
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rooms as $room) :
                    // Fetch residence name based on Residence_ID
                    $residence_id = $room['Residence_ID'];
                    $residence_query = "SELECT Name FROM residence WHERE Residence_ID = $residence_id";
                    $residence_result = mysqli_query($conn, $residence_query);
                    $residence_name = "";

                    if ($residence_result && mysqli_num_rows($residence_result) > 0) {
                        $residence_data = mysqli_fetch_assoc($residence_result);
                        $residence_name = $residence_data['Name'];
                    }
                ?>
                    <tr>
                        <td><?php echo $room['Room_Number']; ?></td>
                        <td><?php echo $room['Room_Type']; ?></td>
                        <td><?php echo $room['Room_Status']; ?></td>
                        <td><?php echo $residence_name; ?></td> <!-- Display residence name -->
                        <td>
                            <form method="post" action="manage_rooms.php">
                                <input type="hidden" name="room_id" value="<?php echo $room['Room_ID']; ?>">
                                <button type="submit" name="edit_room">Edit</button>
                                <button type="submit" name="delete_room">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Form for creating a new room -->
        <h3>Create New Room</h3>
        <form method="post" action="manage_rooms.php">
            <label for="room_number">Room Number:</label>
            <input type="text" id="room_number" name="room_number" required><br>

            <label for="room_type">Room Type:</label>
            <input type="text" id="room_type" name="room_type" required><br>

            <label for="room_status">Room Status:</label>
            <select id="room_status" name="room_status" required>
                <option value="Vacant">Vacant</option>
                <option value="Occupied">Occupied</option>
            </select><br>

            <label for="residence_id">Residence:</label> <!-- Updated label -->
            <select id="residence_id" name="residence_id" required>
                <?php
                // Fetch and display available Residence IDs
                $residence_sql = "SELECT Residence_ID, Name FROM residence"; // Fetch Name along with ID
                $residence_result = mysqli_query($conn, $residence_sql);

                if ($residence_result) {
                    while ($residence_row = mysqli_fetch_assoc($residence_result)) {
                        $residence_id = $residence_row['Residence_ID'];
                        $residence_name = $residence_row['Name']; // Use Name
                        echo "<option value='$residence_id'>$residence_name</option>";
                    }
                }
                ?>
            </select><br>

            <button type="submit" name="create_room">Create Room</button>
        </form>

        <a href="admin.php">Back to Admin Dashboard</a>
    </div>
</body>
</html>
