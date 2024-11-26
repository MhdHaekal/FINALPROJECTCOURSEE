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
        $thumbnailDir = __DIR__ . '/../assets/thumbnails/';
        if (!file_exists($thumbnailDir)) {
            mkdir($thumbnailDir, 0777, true); // Create directory if not exists
        }
        $thumbnailPath = $thumbnailDir . $thumbnailName;
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailPath);
        $thumbnailPath = "../assets/thumbnails/" . $thumbnailName; // Save relative path
    }

    // Upload course content
    $contentPath = null;
    if (isset($_FILES['course_file']) && $_FILES['course_file']['error'] === UPLOAD_ERR_OK) {
        $contentFileName = uniqid() . '_' . basename($_FILES['course_file']['name']);
        $contentDir = __DIR__ . '/../assets/courses/';
        if (!file_exists($contentDir)) {
            mkdir($contentDir, 0777, true); // Create directory if not exists
        }
        $contentPath = $contentDir . $contentFileName;
        move_uploaded_file($_FILES['course_file']['tmp_name'], $contentPath);
        $contentPath = "../assets/courses/" . $contentFileName; // Save relative path
    }

    // Insert course data into database
    $stmt = $pdo->prepare("INSERT INTO kursus (judul, deskripsi, thumbnail, isi_kursus) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $description, $thumbnailPath, $contentPath]);

    header('Location: view_courses.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/add_course.css"> <!-- Use common CSS file for consistency -->
</head>
<body class="bg-light">

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

    <!-- Hero Section with Page Title -->
    <header class="hero py-5 text-center">
        <div class="container">
            <h1 class="display-4 text-white">Add New Course</h1>
            <p class="lead mb-4 text-white">Fill in the form below to add a new course to the platform.</p>
        </div>
    </header>

    <!-- Course Add Form -->
    <div class="container my-5">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Course Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Course Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Course Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_file" class="form-label">Course Content (PDF, Text, Video)</label>
                        <input type="file" name="course_file" id="course_file" class="form-control" accept=".pdf,.txt,.mp4" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Additional Notes (Optional)</label>
                        <textarea name="content" id="content" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add Course</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
