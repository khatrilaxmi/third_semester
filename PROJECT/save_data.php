<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $school_roll_no = $_POST['school_roll_no'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $image_path = '';

    if (isset($_FILES['image'])) {
        $image_path = 'uploads/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    $query = "INSERT INTO students (name, school_roll_no, email, phone_no, image) VALUES ('$name', '$school_roll_no', '$email', '$phone_no', '$image_path')";
    mysqli_query($conn, $query);

    // Redirect back to index.php
    header('Location: index.php');
}
?>
