<!DOCTYPE html>
<html>
<head>
    <title>Add Teacher</title>
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
    $full_name = $teacher_no = $section = $level = '';
    $photo_error = '';

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $full_name = $_POST['full_name'];
        $teacher_no = $_POST['teacher_no'];
        $section = $_POST['section'];
        $level = $_POST['level'];

        // Validate and move uploaded photo
        if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $photo_name = $_FILES['photo']['name'];
            $photo_tmp_name = $_FILES['photo']['tmp_name'];
            $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);
            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

            if (in_array($photo_extension, $allowed_extensions)) {
                $newFileName = uniqid() . '.' . $photo_extension;
                $uploadDirectory = 'uploads/';
                $uploadedFile = $uploadDirectory . $newFileName;

                // Create the "uploads" directory if it doesn't exist
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0755, true);
                }

                if (move_uploaded_file($photo_tmp_name, $uploadedFile)) {
                    // File moved successfully, continue with database insertion
                    $insert_query = "INSERT INTO teachers (full_name, teacher_no, section, level, photo) VALUES ('$full_name', '$teacher_no', '$section', '$level', '$uploadedFile')";
                    $result = mysqli_query($conn, $insert_query);

                    if ($result) {
                        // Teacher added successfully
                        header('Location: teacher.php?teachers=true');
                        exit();
                    } else {
                        // Database insertion failed
                        $photo_error = 'Error: Failed to insert teacher into the database.';
                    }
                } else {
                    // File moving failed
                    $photo_error = 'Error: Failed to move uploaded photo to the server.';
                }
            } else {
                // Invalid photo format
                $photo_error = 'Error: Only JPG, JPEG, PNG, and GIF formats are allowed for photos.';
            }
        } else {
            // No photo uploaded or an error occurred during upload
            $photo_error = 'Error: Failed to upload teacher photo. Please try again.';
        }
    }
    ?>

    <div class="sidebar">
        <h2>School Web App</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="student.php?students=true">Student</a></li>
            <li><a href="teacher.php?teachers=true">Teacher</a></li>
            <li><a href="setting.php">Setting</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <h1>Add Teacher</h1>
        </div>
        <div class="form-container">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" name="full_name" id="full_name" required value="<?php echo $full_name; ?>">
                </div>
                <div class="form-group">
                    <label for="teacher_no">Teacher No:</label>
                    <input type="text" name="teacher_no" id="teacher_no" required value="<?php echo $teacher_no; ?>">
                </div>
                <div class="form-group">
                    <label for="section">Section:</label>
                    <input type="text" name="section" id="section" required value="<?php echo $section; ?>">
                </div>
                <div class="form-group">
                    <label for="level">Level:</label>
                    <input type="text" name="level" id="level" required value="<?php echo $level; ?>">
                </div>
                <div class="form-group">
                    <label for="photo">Photo:</label>
                    <input type="file" name="photo" id="photo" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Add Teacher">
                </div>
            </form>
            <?php if ($photo_error) { ?>
                <p class="error"><?php echo $photo_error; ?></p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
