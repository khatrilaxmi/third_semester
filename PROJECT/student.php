<!DOCTYPE html>
<html>
<head>
    <title>Student Information</title>
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
    ?>

    <div class="sidebar">
        <h2>Shree Ganga Ma Vi</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="student.php?students=true">Student</a></li>
            <?php if ($_SESSION['role'] === 'admin') { ?>
                <li><a href="teacher.php?teachers=true">Teacher</a></li>
                <li><a href="setting.php">Setting</a></li>
            <?php } ?>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <h1>Student Information</h1>
        </div>
        <?php if (isset($_GET['students']) && !empty($students)) { ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>School Roll No</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
                        <th>Username</th>
                        <th>Password</th>
                    <?php } ?>
                    <th>Actions</th>
                </tr>
                <?php foreach ($students as $student) { ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo isset($student['full_name']) ? $student['full_name'] : ''; ?></td>
                        <td><?php echo isset($student['roll_no']) ? $student['roll_no'] : ''; ?></td>
                        <td><?php echo $student['email']; ?></td>
                        <td><?php echo $student['phone_no']; ?></td>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
                            <td><?php echo $student['username']; ?></td>
                            <td><?php echo str_repeat("*", strlen($student['password'])); ?></td>
                        <?php } ?>
                        <td>
                            <a href='view_student.php?id=<?php echo $student['id']; ?>'>View</a>
                            <a href='edit_student.php?id=<?php echo $student['id']; ?>'>Edit</a>
                            <a href='student.php?action=delete_student&id=<?php echo $student['id']; ?>' onclick='return confirm("Are you sure you want to delete this student?")'>Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No student data available.</p>
        <?php } ?>
        <div class="footer">
            <p>© <?php echo date('Y'); ?> Shree Ganga Ma Vi. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
