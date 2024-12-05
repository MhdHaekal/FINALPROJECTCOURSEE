<?php
session_start();
include '../../config/db.php';
include '../../includes/authclass.php';

$auth = new AuthClass($conn);

// Pastikan admin sudah login
if (!$auth->isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$course_query = "SELECT * FROM courses";
$result_courses = $conn->query($course_query);

// Menangani error jika query gagal
if ($result_courses === false) {
    die('Query Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/admin_das.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Dashboard Admin</h2>

        <!-- Card for Course Management -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Kursus</h4>
            </div>
            <div class="card-body">
                <!-- Table displaying course list -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kursus</th>
                            <th>Deskripsi</th>
                            <th>Gambar Sampul</th>
                            <th>Dibuat Pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($course = $result_courses->fetch_assoc()): ?>
                            <tr>
                                <td><?= $course['id']; ?></td>
                                <td><?= $course['title']; ?></td>
                                <td><?= substr($course['description'], 0, 50); ?>...</td> <!-- Potong deskripsi -->
                                <td>
                                    <?php if ($course['image_url']): ?>
                                        <img src="../../assets/images/<?= $course['image_url']; ?>" alt="Image" width="50">
                                    <?php else: ?>
                                        <span>No image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $course['created_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Button Section: Separate from the table -->
        <div class="button-section">
            <div class="d-flex justify-content-start btn-container">
                <a href="views_user.php" class="btn btn-info btn-custom">Lihat Pengguna Terdaftar</a>
                <a href="add_course.php" class="btn btn-primary btn-custom">Tambah Kursus</a>
                <a href="manage_courses.php" class="btn btn-secondary btn-custom">Kelola Kursus</a>
                <a href="../logout.php" class="btn btn-danger btn-custom">Logout</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
