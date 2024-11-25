<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];

    // Upload thumbnail
    $thumbnailPath = null;
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $thumbnailName = uniqid() . '_' . basename($_FILES['thumbnail']['name']);
        $thumbnailDir = __DIR__ . '../assets/thumbnails/';
        if (!file_exists($thumbnailDir)) {
            mkdir($thumbnailDir, 0777, true); // Buat folder jika belum ada
        }
        $thumbnailPath = $thumbnailDir . $thumbnailName;
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailPath);
        $thumbnailPath = "../assets/thumbnails/" . $thumbnailName; // Simpan relative path ke database
    }

    // Upload file isi kursus
    $contentPath = null;
    if (isset($_FILES['course_file']) && $_FILES['course_file']['error'] === UPLOAD_ERR_OK) {
        $contentFileName = uniqid() . '_' . basename($_FILES['course_file']['name']);
        $contentDir = __DIR__ . '../assets/courses/';
        if (!file_exists($contentDir)) {
            mkdir($contentDir, 0777, true); // Buat folder jika belum ada
        }
        $contentPath = $contentDir . $contentFileName;
        move_uploaded_file($_FILES['course_file']['tmp_name'], $contentPath);
        $contentPath = "assets/courses/" . $contentFileName; // Simpan relative path ke database
    }

    // Simpan data kursus ke database
    $stmt = $pdo->prepare("INSERT INTO kursus (judul, deskripsi, thumbnail, isi_kursus) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $description, $thumbnailPath, $contentPath]);

    header('Location: view_courses.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Course</title>
</head>
<body>
    <h1>Add New Course</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Title:</label>
        <input type="text" name="title" required><br><br>
        <label>Description:</label>
        <textarea name="description" required></textarea><br><br>
        <label>Thumbnail:</label>
        <input type="file" name="thumbnail" accept="image/*" required><br><br>
        <label>Course Content (PDF, Text, Video):</label>
        <input type="file" name="course_file" accept=".pdf,.txt,.mp4" required><br><br>
        <label>Additional Notes (Text Content):</label>
        <textarea name="content"></textarea><br><br>
        <button type="submit">Add Course</button>
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
