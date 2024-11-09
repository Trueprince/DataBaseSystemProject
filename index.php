<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Residence System</title>
    <style>
        body {
            background-image: url('background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: white;
            font-weight: bold;
            padding: 20px;
            background-color: red;
            border: 2px solid red;
        }

        .navigation {
            text-align: center;
            margin: 50px;
        }

        .navigation h2 {
            font-weight: bold;
            color: white;
            background-color: red;
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid red;
        }

        .navigation ul {
            list-style-type: none;
            padding: 0;
        }

        .navigation ul li {
            display: inline;
            margin-right: 10px;
        }

        .navigation ul li a {
            display: inline-block;
            color: red;
            font-weight: bold;
            text-decoration: none;
            padding: 10px 20px;
            background-color: white;
            border: 2px solid red;
        }

        footer {
            text-align: center;
            color: white;
            font-weight: bold;
            padding: 10px;
            background-color: red;
            border: 2px solid red;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .logo {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 100px;
        }

        .contact-box {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background-color: red;
            color: white;
            padding: 10px;
            border: 2px solid red;
        }
    </style>
</head>
<body>
    <img src="logo.png" alt="Logo" class="logo">
    <h1>Welcome to the Student Residence System</h1>

    <div class="navigation">
        <h2>Navigation</h2>
        <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="apply_for_residence.php">Apply for Residence</a></li>

            <li><a href="view_application_status.php">View Application Status</a></li>
             
        </ul>
    </div>

    <!-- Include any other HTML content and sections relevant to your project -->

    <div class="contact-box">
        <h2>CONTACT</h2>
        <p>Switchboard: +27 (0)53 491 0000</p>
        <p>Email: information@spu.ac.za</p>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Student Residence System
    </footer>
</body>
</html>


