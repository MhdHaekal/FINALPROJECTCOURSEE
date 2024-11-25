<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../project/auth/login.php');
    exit;
}

include 'config/db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <a href="add_course.php">Add New Course</a> |
    <a href="view_courses.php">Manage Courses</a> |
    <a href="../project/auth/logout.php">Logout</a>
</body>
</html>
