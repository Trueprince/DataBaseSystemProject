<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include your database connection script here
require('db.php');

// Initialize variables
$room_id = $room_number = $room_type = $room_status = $residence_id = "";

// Check if a room ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $room_id = $_GET['id'];

    // Fetch the room details from the database
    $query = "SELECT * FROM room WHERE Room_ID = $room_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $room = mysqli_fetch_assoc($result);
        if ($room) {
            $room_number = $room['Room_Number'];
            $room_type = $room['Room_Type'];
            $room_status = $room['Room_Status'];
            $residence_id = $room['Residence_ID'];
        } else {
            // Room with the provided ID does not exist
            header("Location: rooms.php");
            exit();
        }
    } else {
        // Error fetching room details
        echo "Error: " . mysqli_error($conn);
        exit();
    }
}

// Handle form submissions (room update)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_number = mysqli_real_escape_string($conn, $_POST['room_number']);
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $room_status = mysqli_real_escape_string($conn, $_POST['room_status']);
    $residence_id = mysqli_real_escape_string($conn, $_POST['residence_id']);

    // Update the room details in the database
    $update_query = "UPDATE room SET Room_Number = '$room_number', Room_Type = '$room_type', Room_Status = '$room_status', Residence_ID = '$residence_id' WHERE Room_ID = $room_id";

    if (mysqli_query($conn, $update_query)) {
        header("Location: rooms.php");
        exit();
    } else {
        echo "Error updating room: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room</title>
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

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
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
    </style>
</head>
<body>
    <h2>Edit Room</h2>
    <div class="container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="room_number">Room Number:</label>
            <input type="text" id="room_number" name="room_number" value="<?php echo htmlspecialchars($room_number); ?>" required><br>

            <label for="room_type">Room Type:</label>
            <input type="text" id="room_type" name="room_type" value="<?php echo htmlspecialchars($room_type); ?>" required><br>

            <label for="room_status">Room Status:</label>
            <select id="room_status" name="room_status" required>
                <option value="Vacant" <?php if ($room_status === 'Vacant') echo 'selected'; ?>>Vacant</option>
                <option value="Occupied" <?php if ($room_status === 'Occupied') echo 'selected'; ?>>Occupied</option>
            </select><br>

            <label for="residence_id">Residence ID:</label>
            <select id="residence_id" name="residence_id" required>
                <?php
                // Fetch and display available Residence IDs
                $residence_sql = "SELECT Residence_ID FROM residence";
                $residence_result = mysqli_query($conn, $residence_sql);

                if ($residence_result) {
                    while ($residence_row = mysqli_fetch_assoc($residence_result)) {
                        $residence_id_value = $residence_row['Residence_ID'];
                        $selected = ($residence_id == $residence_id_value) ? 'selected' : '';
                        echo "<option value='$residence_id_value' $selected>$residence_id_value</option>";
                    }
                }
                ?>
            </select><br>

            <input type="submit" value="Update Room">
        </form>
    </div>
</body>
</html>
