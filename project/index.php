<?php
session_start();
include '../admin/config/db.php';

$courses = $pdo->query("SELECT * FROM kursus")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Course Homepage</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Online Courses</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="auth/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-primary text-white text-center py-5">
        <h1>Welcome to Online Courses</h1>
        <p>Explore our courses and enhance your skills</p>
    </div>

    <!-- Available Courses Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Available Courses</h2>
        <div class="row">
            <?php foreach ($courses as $course): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="<?= htmlspecialchars($course['thumbnail']) ?>" class="card-img-top" alt="Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($course['judul']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($course['deskripsi']) ?></p>
                        <a href="courses_detail.php?id=<?= htmlspecialchars($course['id_kursus']) ?>" class="btn btn-primary">View Course</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; <?= date('Y') ?> Online Courses. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
