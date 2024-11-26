<?php
include 'config/db.php';

// Query to fetch student progress data from related tables
$progress = $pdo->query("
    SELECT 
        pk.id_pendaftaran AS id,
        p.nama_lengkap AS student_name,
        k.judul AS course_title,
        pk.persentase_progres AS progress_percentage
    FROM pendaftaran_kursus pk
    JOIN pengguna p ON pk.id_pengguna = p.id_pengguna
    JOIN kursus k ON pk.id_kursus = k.id_kursus
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Progress</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/progress.css">
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
                    <li class="nav-item"><a class="nav-link" href="view_courses.php">Manage Courses</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="../auth/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero py-5 text-center">
        <div class="container">
            <h1 class="display-4 text-white">Student Progress</h1>
            <p class="lead text-white">Track the progress of students enrolled in your courses.</p>
        </div>
    </header>

    <!-- Student Progress Section -->
    <div class="container my-5">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Progress (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($progress as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['id']) ?></td>
                            <td><?= htmlspecialchars($p['student_name']) ?></td>
                            <td><?= htmlspecialchars($p['course_title']) ?></td>
                            <td><?= htmlspecialchars($p['progress_percentage']) ?>%</td>
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
