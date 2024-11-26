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

// Debug untuk memastikan thumbnail
$thumbnailExists = file_exists("../../kursus/admin/assets/thumbnails" . $course['thumbnail']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Course Details</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Back to Homepage</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="h4"><?= htmlspecialchars($course['judul']) ?></h1>
            </div>
            <div class="card-body">
                <?php if ($course['thumbnail']): ?>
                    <?php if ($thumbnailExists): ?>
                        <img src="../admin/assets/thumbnails/ htmlspecialchars($course['thumbnail']) ?>" alt="Thumbnail" class="img-fluid rounded mb-3">
                    <?php else: ?>
                        <p class="text-danger">Thumbnail file not found.</p>
                    <?php endif; ?>
                <?php endif; ?>
                <p><?= nl2br(htmlspecialchars($course['deskripsi'])) ?></p>
                <?php if ($course['isi_kursus']): ?>
                    <a href="../<?= htmlspecialchars($course['isi_kursus']) ?>" class="btn btn-success" download>Download Course Content</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">Back to Homepage</a>
        </div>
    </div>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
