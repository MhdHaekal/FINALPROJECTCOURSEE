<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include 'config/db.php';

// Retrieve courses from database
$courses = $pdo->query("SELECT * FROM kursus")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/view_courses.css">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_course.php">Add New Course</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="../auth/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero py-5 text-center">
        <div class="container">
            <h1 class="display-4 text-white">Manage Courses</h1>
            <p class="lead text-white">View, edit, or delete existing courses in the system.</p>
        </div>
    </header>

    <!-- Manage Courses Section -->
    <div class="container my-5">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                        <tr>
                            <td><?= htmlspecialchars($course['id_kursus']) ?></td>
                            <td><?= htmlspecialchars($course['judul']) ?></td>
                            <td><?= htmlspecialchars($course['deskripsi']) ?></td>
                            <td>
                                <a href="edit_course.php?id=<?= htmlspecialchars($course['id_kursus']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_course.php?id=<?= htmlspecialchars($course['id_kursus']) ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-center mt-3">
                    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
