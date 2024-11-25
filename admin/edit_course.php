<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../project/auth/login.php');
    exit;
}

include 'config/db.php';

$id = $_GET['id'];
$course = $pdo->query("SELECT * FROM kursus WHERE id_kursus = $id")->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE kursus SET judul = ?, deskripsi = ? WHERE id_kursus = ?");
    $stmt->execute([$title, $description, $id]);

    header('Location: view_courses.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
</head>
<body>
    <h1>Edit Course</h1>
    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($course['judul']) ?>" required><br><br>
        <label>Description:</label>
        <textarea name="description" required><?= htmlspecialchars($course['deskripsi']) ?></textarea><br><br>
        <button type="submit">Save Changes</button>
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
