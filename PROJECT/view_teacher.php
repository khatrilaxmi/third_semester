<!DOCTYPE html>
<html>
<head>
    <title>View Teacher Details</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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

    // Check if the teacher ID is provided in the URL
    if (!isset($_GET['id'])) {
        header('Location: teachers.php');
        exit();
    }

    $teacher_id = $_GET['id'];

    // Query to fetch the teacher's information
    $query = "SELECT * FROM teachers WHERE id = $teacher_id";
    $result = mysqli_query($conn, $query);
    $teacher = mysqli_fetch_assoc($result);

    // Check if the teacher exists in the database
    if (!$teacher) {
        echo "Teacher not found.";
        exit();
    }
    ?>

    <div class="header">
        <h1>Teacher Information</h1>
    </div>
    <div class="content">
        <div class="teacher-details">
            <h2><?php echo $teacher['full_name']; ?></h2>
            <p><strong>ID:</strong> <?php echo $teacher['id']; ?></p>
            <p><strong>Teacher No:</strong> <?php echo $teacher['teacher_no']; ?></p>
            <p><strong>Section:</strong> <?php echo $teacher['section']; ?></p>
            <p><strong>Level:</strong> <?php echo $teacher['level']; ?></p>
            <img src="<?php echo $teacher['photo']; ?>" alt="Teacher Photo">
        </div>
    </div>
    <div class="footer">
        <p>© <?php echo date('Y'); ?> School Web Application. All rights reserved.</p>
    </div>
</body>
</html>
