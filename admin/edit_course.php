<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/edit_course.css">
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
            <h1 class="display-4 text-white">Edit Course</h1>
            <p class="lead text-white">Modify the details of the selected course.</p>
        </div>
    </header>

    <!-- Edit Form Section -->
    <div class="container my-5">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                <form method="POST" class="mt-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">Course Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($course['judul']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Course Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required><?= htmlspecialchars($course['deskripsi']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                    <a href="view_courses.php" class="btn btn-secondary w-100 mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
