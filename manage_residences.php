<?php
session_start();

// Check if the user is logged in and has the necessary role (e.g., admin or manager)
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Database connection script here
require('db.php');

// Handle residence management actions here (e.g., adding or deleting)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submissions here
    if (isset($_POST['add_residence'])) {
        // Handle adding a new residence
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
        $manager = mysqli_real_escape_string($conn, $_POST['manager']);
        $deadline = mysqli_real_escape_string($conn, $_POST['deadline']);
        $availability_status = mysqli_real_escape_string($conn, $_POST['availability_status']);

// Perform database INSERT to add a new residence
        $insert_sql = "INSERT INTO residence (Name, Address, Capacity, Residence_Manager, Application_Deadline, Availability_Status) 
        VALUES ('$name', '$address', '$capacity', '$manager', '$deadline', '$availability_status')";
        
        if (mysqli_query($conn, $insert_sql)) {
            // Successfully added a residence
            header("Location: view_residence.php");
            exit();
        } else {
// Handle error if the INSERT fails
            $error = "Failed to add residence: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_residence'])) {
// Handle deleting a residence
        $residence_id = mysqli_real_escape_string($conn, $_POST['residence_id']);

// Perform database DELETE to remove the residence
        $delete_sql = "DELETE FROM residence WHERE Residence_ID = '$residence_id'";
        
        if (mysqli_query($conn, $delete_sql)) {
            // Successfully deleted the residence
            header("Location:view_residence.php");
            exit();
        } else {
            // Handle error if the DELETE fails
            $error = "Failed to delete residence: " . mysqli_error($conn);
        }
    }
}

// Fetching residence data from the database
$sql = "SELECT * FROM residence";
$result = mysqli_query($conn, $sql);

// HTML for the manage residence page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Residence</title>
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

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-top: 5px;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
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
    <h2>Manage Residence</h2>
    <div class="container">

        <!-- Add Residence Form -->
        <h3>Add Residence</h3>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="residence_id" value="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required><br>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" required><br>

            <label for="manager">Residence Manager:</label>
            <input type="text" id="manager" name="manager" required><br>

            <label for="deadline">Application Deadline:</label>
            <input type="date" id="deadline" name="deadline" required><br>

            <label for="availability_status">Availability Status:</label>
            <select id="availability_status" name="availability_status" required>
                <option value="available">Available</option>
                <option value="not_available">Not Available</option>
            </select><br>

            <input type="submit" name="add_residence" value="Add Residence">
        </form>

        <!-- Delete Residence Section -->
        <h3>Delete Residence</h3>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="residence_id">Select Residence to Delete:</label>
            <select id="residence_id" name="residence_id">
                <?php
                // Reset the result pointer to the beginning
                mysqli_data_seek($result, 0);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['Residence_ID'] . "'>" . $row['Name'] . "</option>";
                }
                ?>
            </select>
            <input type="submit" name="delete_residence" value="Delete Residence">
        </form>

        <a href="admin.php">Back to Dashboard</a>
    </div>
</body>
</html>


