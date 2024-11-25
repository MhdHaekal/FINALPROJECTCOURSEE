<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../project/auth/login.php');
    exit;
}

include 'config/db.php';

$courses = $pdo->query("SELECT * FROM kursus")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>
</head>
<body>
    <h1>Manage Courses</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($courses as $course): ?>
        <tr>
            <td><?= htmlspecialchars($course['id_kursus']) ?></td>
            <td><?= htmlspecialchars($course['judul']) ?></td>
            <td><?= htmlspecialchars($course['deskripsi']) ?></td>
            <td>
                <a href="edit_course.php?id=<?= htmlspecialchars($course['id_kursus']) ?>">Edit</a> |
                <a href="delete_course.php?id=<?= htmlspecialchars($course['id_kursus']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
