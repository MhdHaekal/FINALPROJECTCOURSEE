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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/index.css">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../../project/index.php">Online Courses</a>
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
    <header class="hero-section">
        <div class="container text-center text-white py-5">
            <h1 class="fw-bold">Welcome to Online Courses</h1>
            <p class="lead">Explore our courses and enhance your skills</p>
            <a href="#courses" class="btn btn-light btn-lg rounded-pill shadow">Discover More</a>
        </div>
    </header>

    <!-- Available Courses Section -->
    <main class="container my-5" id="courses">
        <h2 class="text-center text-dark mb-4">Available Courses</h2>
        <div class="row">
            <?php foreach ($courses as $course): ?>
            <div class="col-md-4">
                <div class="card course-card mb-4 shadow-sm">
                    <img src="<?= htmlspecialchars($course['thumbnail']) ?>" class="card-img-top" alt="Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($course['judul']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($course['deskripsi']) ?></p>
                        <a href="courses_detail.php?id=<?= htmlspecialchars($course['id_kursus']) ?>" class="btn btn-primary w-100">View Course</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="footer py-5 text-white">
    <div class="container">
        <div class="row text-center text-md-start">
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold">Online Courses</h5>
                <p>Your trusted platform to learn and grow. Join our community of learners today!</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none text-white">Home</a></li>
                    <li><a href="#" class="text-decoration-none text-white">Courses</a></li>
                    <li><a href="#" class="text-decoration-none text-white">About Us</a></li>
                    <li><a href="#" class="text-decoration-none text-white">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-3 text-md-end">
                <h5 class="fw-bold">Follow Us</h5>
                <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
                <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
        <div class="text-center mt-4">
            <p>&copy; <?= date('Y') ?> Online Courses. All rights reserved.</p>
        </div>
    </div>
</footer>
</body>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
