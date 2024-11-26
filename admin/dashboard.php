<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../project/auth/login.php');
    exit;
}

include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="add_course.php">Add New Course</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_courses.php">Manage Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="progress.php">View Progress</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="../project/auth/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero py-5 text-center">
        <div class="container">
            <h1 class="display-4 fw-bold welcome-text">Welcome Admin</h1>
            <p class="lead mb-4">Manage your courses, track student progress, and keep everything running smoothly.</p>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Card 1: Add New Course -->
            <div class="col">
                <div class="card shadow-sm border-0 rounded-3 hover-effect">
                    <div class="card-body text-center">
                        <i class="bi bi-plus-circle-fill" style="font-size: 50px; color: #8AB6F9;"></i>
                        <h5 class="card-title text-primary">Add New Course</h5>
                        <p class="card-text text-muted">Create new courses with all the materials and content needed.</p>
                        <a href="add_course.php" class="btn btn-primary w-100">Add Course</a>
                    </div>
                </div>
            </div>

            <!-- Card 2: Manage Courses -->
            <div class="col">
                <div class="card shadow-sm border-0 rounded-3 hover-effect">
                    <div class="card-body text-center">
                        <i class="bi bi-gear-fill" style="font-size: 50px; color: #f0ad4e;"></i>
                        <h5 class="card-title text-primary">Manage Courses</h5>
                        <p class="card-text text-muted">Edit, update, or delete existing courses.</p>
                        <a href="view_courses.php" class="btn btn-warning w-100">Manage Courses</a>
                    </div>
                </div>
            </div>

            <!-- Card 3: View Progress -->
            <div class="col">
                <div class="card shadow-sm border-0 rounded-3 hover-effect">
                    <div class="card-body text-center">
                        <i class="bi bi-bar-chart-fill" style="font-size: 50px; color: #28a745;"></i>
                        <h5 class="card-title text-primary">View Progress</h5>
                        <p class="card-text text-muted">Monitor and track student progress in enrolled courses.</p>
                        <a href="progress.php" class="btn btn-success w-100">View Progress</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
