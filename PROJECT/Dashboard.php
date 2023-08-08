<!DOCTYPE html>
<html>
<head>
    <title>Student and Teacher Management System</title>
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

    // Handle student deletion when the "Delete" link is clicked
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $student_id = $_GET['id'];
        $delete_query = "DELETE FROM students WHERE id = $student_id";
        $result = mysqli_query($conn, $delete_query);
        if ($result) {
            header('Location: index.php');
            exit();
        }
    }

    // Handle teacher deletion when the "Delete" link is clicked
    if (isset($_GET['action']) && $_GET['action'] === 'delete_teacher' && isset($_GET['id'])) {
        $teacher_id = $_GET['id'];
        $delete_query = "DELETE FROM teachers WHERE id = $teacher_id";
        $result = mysqli_query($conn, $delete_query);
        if ($result) {
            header('Location: index.php?teachers=true');
            exit();
        }
    }

    // Fetch the student information when "Student" link is clicked
    $students = array();
    if (isset($_GET['students'])) {
        $query = "SELECT * FROM students";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $students[] = $row;
            }
        }
    }

    // Fetch the teacher information when "Teacher" link is clicked
    $teachers = array();
    if (isset($_GET['teachers'])) {
        $query = "SELECT * FROM teachers";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $teachers[] = $row;
            }
        }
    }
    ?>

    <div class="sidebar">
        <h2>Shree Ganga Ma Vi</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="student.php?students=true">Student</a></li>
            <?php if ($_SESSION['role'] === 'admin') { ?>
                <li><a href="teacher.php?teachers=true">Teacher</a></li>
            <?php } ?>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <h1><?php echo ($_SESSION['role'] === 'admin') ? "Student and Teacher Management" : "Student Information"; ?></h1>
        </div>
        <?php if ($_SESSION['role'] === 'admin') { ?>
            <div class="add-new-button">
                <button><a href="add_student.php">Add New Student</a></button>
                <button><a href="add_teacher.php">Add New Teacher</a></button>
            </div>
        <?php } ?>
        <?php if ($_SESSION['role'] === 'admin' && isset($_GET['students'])) { ?>
            <?php if (empty($students)) { ?>
                <p>No student data available.</p>
            <?php } else { ?>
                <table>
                    <!-- Table for students goes here -->
                </table>
            <?php } ?>
        <?php } ?>

        <?php if ($_SESSION['role'] === 'admin' && isset($_GET['teachers'])) { ?>
            <?php if (empty($teachers)) { ?>
                <p>No teacher data available.</p>
            <?php } else { ?>
                <table>
                    <!-- Table for teachers goes here -->
                </table>
            <?php } ?>
        <?php } ?>
        <div class="footer">
            <p>© <?php echo date('Y'); ?> Shree Ganga Ma Vi. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
