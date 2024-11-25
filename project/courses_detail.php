<?php
session_start();
include '../admin/config/db.php';

// Validasi parameter `id`
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid course ID.");
}

$id = $_GET['id'];

// Query untuk mendapatkan detail kursus
$course = $pdo->prepare("SELECT * FROM kursus WHERE id_kursus = ?");
$course->execute([$id]);
$course = $course->fetch(PDO::FETCH_ASSOC);

// Jika kursus tidak ditemukan
if (!$course) {
    die("The course you are looking for does not exist.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Course Details</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .course-detail { max-width: 800px; margin: auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px; }
        .course-detail img { max-width: 100%; height: auto; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="course-detail">
        <h1><?= htmlspecialchars($course['judul']) ?></h1>
        <?php if ($course['thumbnail']): ?>
            <img src="../<?= htmlspecialchars($course['thumbnail']) ?>" alt="Thumbnail">
        <?php endif; ?>
        <p><?= nl2br(htmlspecialchars($course['deskripsi'])) ?></p>
        <?php if ($course['isi_kursus']): ?>
            <a href="../<?= htmlspecialchars($course['isi_kursus']) ?>" download>Download Course Content</a>
        <?php endif; ?>
        <p><a href="index.php">Back to Homepage</a></p>
    </div>
</body>
</html>
