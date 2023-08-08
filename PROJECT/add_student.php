<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php
    session_start();

    // Check if the user is not logged in or not an admin, redirect to login page
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: login.php');
        exit();
    }

    require_once 'db_connection.php';

    // Variables to hold form data
    $full_name = $roll_no = $email = $phone_no = $username = $password = $confirm_password = '';
    $password_error = '';

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $full_name = $_POST['full_name'];
        $roll_no = $_POST['roll_no'];
        $email = $_POST['email'];
        $phone_no = $_POST['phone_no'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate and insert student data into the database
        if ($password === $confirm_password) {
            // Passwords match, continue with database insertion
            $insert_query = "INSERT INTO students (full_name, roll_no, email, phone_no, username, password) VALUES ('$full_name', '$roll_no', '$email', '$phone_no', '$username', '$password')";
            $result = mysqli_query($conn, $insert_query);

            if ($result) {
                // Student added successfully
                header('Location: student.php?students=true');
                exit();
            } else {
                // Database insertion failed
                $password_error = 'Error: Failed to insert student into the database.';
            }
        } else {
            // Passwords do not match
            $password_error = 'Error: Password and Confirm Password do not match.';
        }
    }
    ?>

    <div class="sidebar">
        <h2>School Web App</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="student.php?students=true">Student</a></li>
            <li><a href="teacher.php?teachers=true">Teacher</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <h1>Add Student</h1>
        </div>
        <div class="form-container">
            <form method="post">
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" name="full_name" id="full_name" required value="<?php echo $full_name; ?>">
                </div>
                <div class="form-group">
                    <label for="roll_no">School Roll No:</label>
                    <input type="text" name="roll_no" id="roll_no" required value="<?php echo $roll_no; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
                    <label for="phone_no">Phone No:</label>
                    <input type="text" name="phone_no" id="phone_no" required value="<?php echo $phone_no; ?>">
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required value="<?php echo $username; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required value="<?php echo $password; ?>">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" required value="<?php echo $confirm_password; ?>">
                </div>
                <div class="form-group">
                    <input type="submit" value="Add Student">
                </div>
            </form>
            <?php if ($password_error) { ?>
                <p class="error"><?php echo $password_error; ?></p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
