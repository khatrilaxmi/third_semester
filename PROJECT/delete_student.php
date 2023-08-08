<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the student details for confirmation
    $query = "SELECT * FROM students WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $student = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $id = $_POST['id'];

    // Delete the student from the database
    $query = "DELETE FROM students WHERE id = $id";
    mysqli_query($conn, $query);

    // Redirect back to index.php after successful deletion
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Delete Student</h2>
        <?php if ($student) { ?>
            <p>Are you sure you want to delete the following student?</p>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>School Roll No</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Image</th>
                </tr>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['school_roll_no']; ?></td>
                    <td><?php echo $student['email']; ?></td>
                    <td><?php echo $student['phone_no']; ?></td>
                    <td><img src="<?php echo $student['image']; ?>" alt="Student Image"></td>
                </tr>
            </table>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="confirm">Confirm Deletion (type 'yes'): </label>
                <input type="text" name="confirm" required>
                <button type="submit">Delete</button>
                <button><a href="index.php">Cancel</a></button>
            </form>
        <?php } else { ?>
            <p>Student not found.</p>
            <button><a href="index.php">Back to Home</a></button>
        <?php } ?>
    </div>
</body>
</html>
