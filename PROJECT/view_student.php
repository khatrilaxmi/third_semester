<!DOCTYPE html>
<html>
<head>
    <title>View Student Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="View_Student.css">
</head>
<body>
    <?php
    session_start();

    // Check if the user is not logged in, redirect to login page
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    require_once 'db_connection.php';

    // Check if the student ID is provided in the URL
    if (!isset($_GET['id'])) {
        header('Location: index.php');
        exit();
    }

    $student_id = $_GET['id'];

    // Query to fetch the student's information
    $query = "SELECT * FROM students WHERE id = $student_id";
    $result = mysqli_query($conn, $query);
    $student = mysqli_fetch_assoc($result);

    // Check if the student exists in the database
    if (!$student) {
        echo "Student not found.";
        exit();
    }
    ?>

    <div class="header">
        <h1>Student Information</h1>
    </div>
    <div class="content">
        <div class="student-details">
            <h2><?php echo $student['name']; ?></h2>
            <p><strong>ID:</strong> <?php echo $student['id']; ?></p>
            <p><strong>School Roll No:</strong> <?php echo $student['school_roll_no']; ?></p>
            <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
            <p><strong>Phone No:</strong> <?php echo $student['phone_no']; ?></p>
            <img src="<?php echo $student['image']; ?>" alt="Student Image">
        </div>
        <div class="footer">
            <p>© <?php echo date('Y'); ?> School Web Application. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
